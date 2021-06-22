<?php

namespace App\Actions\Auth\Traits;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

trait PasswordUpdater
{
    /**
     * Update given user password field.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param string                                     $password
     * @param bool                                       $withoutRemember
     *
     * @return void
     */
    protected function updatePassword(Authenticatable $user, string $password, bool $withoutRemember = false): void
    {
        DB::transaction(function () use ($user, $password, $withoutRemember) {
            $user->forceFill(
                array_merge([
                    'password' => Hash::make($password),
                ], $withoutRemember ? [] : ['remember_token' => Str::random(60)])
            )->save();
        });
    }
}
