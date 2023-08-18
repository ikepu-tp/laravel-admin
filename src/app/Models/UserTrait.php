<?php

namespace ikepu_tp\LaravelAdmin\app\Models;

trait UserTrait
{
    public function user_grants()
    {
        return $this->hasMany(User_grant::class, "user_id");
    }
}
