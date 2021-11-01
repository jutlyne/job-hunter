<?php

namespace App\Http\Resources;

use App\Enums\GaragePrioritize;
use Illuminate\Http\Resources\Json\JsonResource;

class Garage extends JsonResource
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
            'id' => $this->garage_id,
            'avatar' => $this->garage->avatar_url,
            'thumbnail' => $this->garage->thumbnail_url,
            'name' => $this->garage->name,
            'email' => $this->garage->email,
            'slug' => $this->garage->slug,
            'phone' => $this->phone,
            'latitude' => doubleval($this->garage->latitude),
            'longitude' => doubleval($this->garage->longitude),
            'description' => $this->garage->description,
            'images' => $this->garage->banners,
            'review_count' => $this->garage->reviews()->count(),
            'review_images_count' => $this->garage->reviewImages()->count(),
            'phone_verified_at' => $this->phone_verified_at,
            'address' => $this->garage->address,
            'rating' => $this->garage->rating,
            'avg_rating' => $this->garage->avg_rating,
            'rating_services' => $this->garage->rating_services,
            'role_id' => 2,
            'prioritize' => ($this->prioritize == GaragePrioritize::PARTNER) ? true : false,
            'province_id' => intval($this->garage->province_id),
            'province' => $this->garage->province->name ?? '',
            'district_id' => intval($this->garage->district_id),
            'district' => $this->garage->district->name ?? '',
            'device_id' => $this->device_id,
        ];
    }
}
