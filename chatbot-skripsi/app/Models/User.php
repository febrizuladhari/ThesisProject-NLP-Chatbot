<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'role_id',
        'username',
        'email',
        'password',
        'is_profile_completed',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
            'password' => 'hashed',
            'is_profile_completed' => 'boolean',
        ];
    }


    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function personal()
    {
        return $this->hasOne(Personal::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    public function isAdmin()
    {
        return $this->role->role === 'admin';
    }

    public function isUser()
    {
        return $this->role->role === 'user';
    }

}
