<?php

namespace App\Repositories\Application\Employer;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWK;
use Twilio\Jwt\JWT;
use Firebase\JWT\SignatureInvalidException;
use App\Enums\ApplicationStatus;
use App\Enums\EducationLevels;
use App\Enums\ExperienceEnums;
use App\Enums\Languages;
use App\Models\Application;
use App\Models\Employer;
use App\Models\User;
use App\Models\UserProfile;

class ApplicationRepositoryEloquent extends BaseRepository implements ApplicationRepository
{
    public function model()
    {
        return Application::class;
    }

    public function countStatusByDate($employerId, $from, $to = null)
    {
        $query = $this->model
            ->where('employer_id', $employerId)
            ->groupBy('status')
            ->select(DB::raw('COUNT(*) as count'), 'status');

        if ($to) {
            $query->whereDate('apply_date', '>=', $from)
                ->whereDate('apply_date', '<=', $to);
        } else {
            $query->whereDate('apply_date', $from);
        }
        return $query->get();
    }

    public function getAll()
    {
        return $this->model
            ->where('employer_id', auth('store')->user()->id)
            ->orderBy('status')
            ->orderBy('apply_date')
            ->get();
    }

    public function getInfoUser($id)
    {
        $data = UserProfile::where('user_id', $id)->first();
        $data['experience'] = ExperienceEnums::getDescription($data->experience);
        $data['education'] = EducationLevels::getDescription($data->education);
        $data['language'] = Languages::getDescription($data->language);
        $data['quote'] = Str::limit($data->quote, '75', '...');

        return $data;
    }

    public function sendEmailRefuse($id)
    {
        $apply = $this->model->find($id);
        $user = User::find($apply->user_id);

        $employer = Employer::find(auth('store')->user()->id)->name;
        $data = [
            'name' => $user->name,
            'employer' => $employer
        ];

        $to_email = $user->email;

        Mail::send('mail.send-refuse', $data, function ($message) use ($to_email) {
            $message->to($to_email)->subject('Sorry');
            $message->from('vocaoky290999@gmail.com', 'Jobs Hunt');
        });

        return $apply->update(['status' => ApplicationStatus::CANCELED]);
    }

    public function getInfoAgree($id)
    {
        return $this->model->find($id);
    }

    public function sendMailAgree($params)
    {
        try {
            $apply = $this->model->find($params['id']);
            $to_email = $apply->user->email;
            $params['name'] = $apply->user->name;
            $params['employer'] = $apply->employer->name;
            $params['date'] = Carbon::parse($params['date'])->format('h:i A, l, d/m/Y');
            $data = [
                'topic' => $params['employer'],
                'start_date' => date($params['date']),
                'duration' => $params['duration'] ?? 30,
                'type' => 2
            ];
            if ($params['password']) {
                $data['password'] = $params['password'];
            }

            $createZoom = $this->createMeeting($data);
            $params['url'] = $createZoom->join_url;

            $apply->zoom_url = $createZoom->join_url;
            $apply->zoom_id = $createZoom->id;
            $apply->zoom_password = $createZoom->password;
            $apply->status = ApplicationStatus::ACCEPT;
            // $apply->due_at = Carbon::parse($params['date'])->addHour()->format('Y-m-d H:i');

            Mail::send('mail.send-agree', $params, function ($message) use ($to_email) {
                $message->to($to_email)->subject('Congratulation');
                $message->from('vocaoky290999@gmail.com', 'Jobs Hunt');
            });

            $apply->save();

            return true;
        } catch (Exception $e) {
            Log::error($e);

            return false;
        }
    }

    //function to generate JWT
    private function generateJWTKey()
    {
        $key = config('services.zoom.client_id');
        $secret = config('services.zoom.client_secret');

        $token = array(
            "iss" => $key,
            "exp" => time() + 3600 //60 seconds as suggested
        );

        return JWT::encode($token, $secret);
    }

    //function to create meeting
    public function createMeeting($data = array())
    {
        $post_time  = $data['start_date'];
        $start_time = gmdate("Y-m-d\TH:i:s", strtotime($post_time));

        $createMeetingArray = array();
        if (!empty($data['alternative_host_ids'])) {
            if (count($data['alternative_host_ids']) > 1) {
                $alternative_host_ids = implode(",", $data['alternative_host_ids']);
            } else {
                $alternative_host_ids = $data['alternative_host_ids'][0];
            }
        }

        $createMeetingArray['topic'] = $data['topic'];
        $createMeetingArray['agenda'] = !empty($data['agenda']) ? $data['agenda'] : "";
        $createMeetingArray['type'] = !empty($data['type']) ? $data['type'] : 2; //Scheduled
        $createMeetingArray['start_time'] = $start_time;
        $createMeetingArray['timezone'] = 'Asia/Ho_Chi_Minh';
        $createMeetingArray['password'] = !empty($data['password']) ? $data['password'] : "";
        $createMeetingArray['duration'] = !empty($data['duration']) ? $data['duration'] : 60;

        $createMeetingArray['settings']   = array(
            'join_before_host' => !empty($data['join_before_host']) ? true : false,
            'host_video' => !empty($data['option_host_video']) ? true : false,
            'participant_video' => !empty($data['option_participants_video']) ? true : false,
            'mute_upon_entry' => !empty($data['option_mute_participants']) ? true : false,
            'enforce_login' => !empty($data['option_enforce_login']) ? true : false,
            'auto_recording' => !empty($data['option_auto_recording']) ? $data['option_auto_recording'] : "none",
            'alternative_hosts' => isset($alternative_host_ids) ? $alternative_host_ids : ""
        );

        // return $createMeetingArray;
        return $this->sendRequest($createMeetingArray);
    }

    //function to send request
    public function sendRequest($data)
    {
        //Enter_Your_Email
        $request_url = "https://api.zoom.us/v2/users/" . config('services.zoom.user') . "/meetings";
        $headers = array(
            "authorization: Bearer " . $this->generateJWTKey(),
            "content-type: application/json",
            "Accept: application/json",
        );

        $postFields = json_encode($data);

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $request_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postFields,
            CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if (!$response) {
            return $err;
        }
        return json_decode($response);
    }

    public function getZoomInfo($id)
    {
        $info = $this->model->find($id);

        return [
            'fname' => $info->user->name,
            'zoom_id' => $info->zoom_id,
            'zoom_url' => $info->zoom_url,
            'zoom_password' => $info->zoom_password
        ];
    }
}
