<?php

namespace App\Traits;

use App\Notifications\User\SendVerifySms;

trait MustVerifyMobile
{
    public function hasVerifiedMobile(): bool
    {
        return ! is_null($this->phone_verified_at);
    }

    public function markMobileAsVerified(): bool
    {
        return $this->forceFill([
            'phone_verified_at' => $this->freshTimestap(),
        ])->save();
    }

    public function sendMobileVerificationNotification(): void
    {
        $this->notify(new SendVerifySms);
    }

    public function checkMobileCode()
    {
        //
    }
}
