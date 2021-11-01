<?php

namespace App\Observers;

use App\Models\Garage;
use App\Models\Staff;
use Illuminate\Support\Str;

class StaffObserver
{
    /**
     * Handle the Staff "created" event.
     *
     * @param  \App\Models\Staff  $staff
     * @return void
     */
    public function created(Staff $staff)
    {
        if(!$staff->garage_id) {
            $garage = Garage::create([
                'name' => Str::random(10),
                'slug' => Str::random(10),
                'phone' => $staff->phone,
                'status' => 1
            ]);

            $staff->update(['garage_id' => $garage->id]);
        }
    }

    /**
     * Handle the Staff "updating" event.
     *
     * @param  \App\Models\Staff  $staff
     * @return void
     */
    public function updating(Staff $staff)
    {

    }

    /**
     * Handle the Staff "updated" event.
     *
     * @param  \App\Models\Staff  $staff
     * @return void
     */
    public function updated(Staff $staff)
    {
        //
    }

    /**
     * Handle the Staff "deleted" event.
     *
     * @param  \App\Models\Staff  $staff
     * @return void
     */
    public function deleted(Staff $staff)
    {
        //
    }

    /**
     * Handle the Staff "restored" event.
     *
     * @param  \App\Models\Staff  $staff
     * @return void
     */
    public function restored(Staff $staff)
    {
        //
    }

    /**
     * Handle the Staff "force deleted" event.
     *
     * @param  \App\Models\Staff  $staff
     * @return void
     */
    public function forceDeleted(Staff $staff)
    {
        //
    }
}
