<?php

namespace App\Traits;

use Illuminate\Auth\Notifications\VerifyEmail;

trait MustVerifyPhone
{
    /**
     * Determine if the user has verified their phone number.
     * @return bool
     */
    public function hasVerifiedPhone()
    {
        return ! is_null($this->phone_verified_at);
    }

    /**
     * Mark the given user's phone as verified.
     *
     * @return bool
     */
    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'phone_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Get the phone number that should be used for verification.
     *
     * @return string
     */
    public function getPhoneForVerification()
    {
        return $this->phone;
    }
}
