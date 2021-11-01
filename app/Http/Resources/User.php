<?php

namespace App\Http\Resources;

use App\Enums\UserRole;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'avatar' => $this->avatar_url,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'province_id' => intval($this->province_id),
            'province' => $this->province->name ?? '',
            'district_id' => intval($this->district_id),
            'district' => $this->district->name ?? '',
            'provider_id' => $this->provider_id,
            'provider' => $this->provider,
            'phone_verified_at' => $this->phone_verified_at,
            'role_id' => 3,
            'device_id' => $this->device_id,
        ];
    }
}
