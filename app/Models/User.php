<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'employee_code',
        'department_id',
        'work_pattern_id',
        'role',
        'is_active',
        'joined_at',
        'password',
        'profile_photo_path',
        'current_team_id',
        'two_factor_enabled',
        'two_factor_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'two_factor_confirmed_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'two_factor_enabled' => 'boolean',
            'joined_at' => 'date',
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Check if user is using email OTP 2FA.
     */
    public function usesEmailOtp(): bool
    {
        return $this->two_factor_enabled && $this->two_factor_type === 'email';
    }

    /**
     * Check if user is using authenticator 2FA.
     */
    public function usesAuthenticator(): bool
    {
        return $this->two_factor_secret !== null && $this->two_factor_type === 'authenticator';
    }

    /**
     * The name of the "deleted at" column.
     */
    const DELETED_AT = 'deleted_at';

    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user is a leader.
     */
    public function isLeader(): bool
    {
        return $this->role === 'leader';
    }

    /**
     * Check if the user is a regular user.
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Check if the user account is active.
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }
}
