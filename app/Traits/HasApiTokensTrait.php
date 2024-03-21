<?php

namespace App\Traits;

/*
 * API NED CURIER | HasApiTokensTrait.php
 * https://www.webdirect.ro/
 * Copyright 2022 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 11/21/2022 11:46 PM
*/

use DateTimeInterface;
use Laravel\Sanctum\HasApiTokens as SanctumHasApiTokens;
use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\PersonalAccessToken;

trait HasApiTokensTrait
{
    use SanctumHasApiTokens;

    /**
     * @param string $name
     * @param DateTimeInterface|null $expiresAt
     * @param array $abilities
     * @return NewAccessToken
     */
    public function createAuthToken(
        string $name,
        DateTimeInterface $expiresAt = null
    ): NewAccessToken {
        return $this->createToken(
            $name,
            ['WD-Auth', "*"],
            $expiresAt ?? now()->addMinutes(config('sanctum-refresh-token.auth_token_expiration'))
        );
    }

    /**
     * @return mixed
     */
    public function refreshAuthToken(User $user)
    {
        $personalTokenModel = PersonalAccessToken::where("tokenable_id", $user->id)->first();
        $personalTokenModel->expires_at = $personalTokenModel->expires_at->addMinutes(
            config('sanctum-refresh-token.refresh_token_expiration')
        );
        return $personalTokenModel->save();
    }
}
