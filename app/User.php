<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'username', 'email', 'password',
    // ];
    protected $guarded = [];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(
            function ($user) {
                if (!$user->name) {
                    $user->update([
                        'name' => $user->username,
                    ]);
                }
            }
        );
    }

    /**
     * @return avatar of user
     */
    public function getAvatar()
    {
        return $this->image ? '/storage/' . $this->image : '/img/no-user.png';
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class)->withPivot('permission')->withTimestamps();
    }
}
