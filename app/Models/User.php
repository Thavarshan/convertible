<?php

namespace App\Models;

use Emberfuse\Scorch\Contracts\Auth\HasApiTokens as ApiTokenContract;
use Emberfuse\Scorch\Models\Concerns\InteractsWithSessions;
use Emberfuse\Scorch\Models\Traits\HasApiTokens;
use Emberfuse\Scorch\Models\Traits\HasProfilePhoto;
use Emberfuse\Scorch\Models\Traits\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements ApiTokenContract
{
    use HasFactory;
    use Notifiable;
    use HasApiTokens;
    use HasProfilePhoto;
    use InteractsWithSessions;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'username',
        'settings',
        'address',
        'locked',
        'profile_photo_path',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'two_factor_enabled' => 'boolean',
        'settings' => 'array',
        'address' => 'array',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
        'sessions',
        'two_factor_enabled',
    ];

    /**
     * Get all conversions that belong to this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function conversions(): HasMany
    {
        return $this->hasMany(Conversion::class);
    }
}
