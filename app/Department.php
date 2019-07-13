<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('permission')->withTimestamps();
    }

    /**
     * Kiểm tra xem có user này ko
     * @param 1 người dùng
     * @return true, false
     */
    public function hasUser($user)
    {
        return $this->users->contains($user->id);
    }
}
