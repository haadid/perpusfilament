<?php

namespace App\Models;

use App\Enums\UserStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'address',
        'phone',
        'status',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'rememberToken'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'status' => UserStatus::class,
            'password' => 'hashed',
        ];
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function blacklists(): HasMany
    {
        return $this->hasMany(Blacklist::class);
    }

    public function librarianActivities(): HasMany
    {
        return $this->hasMany(LibrarianActivity::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function validationBooks(): HasMany
    {
        return $this->hasMany(ValidationBook::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function fines(): HasMany
    {
        return $this->hasMany(Fine::class);
    }

    public function assignRole(Role $role): Model
    {
        return $this->roles()->save($role);
    }
}
