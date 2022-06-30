<?php

namespace App\Repositories;

use App\Models\UserMemberProfile;

class UserMemberProfileRepository
{
    private $model;

    public function __construct(UserMemberProfile $model)
    {
        $this->model = $model;
    }

    public function findByColumn($value, $column)
    {
        return $this->model->where($column, $value)->first();
    }

    public function store(UserMemberProfile $profile)
    {
        $profile = $profile->save();
        return $profile;
    }
}