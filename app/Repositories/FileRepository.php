<?php

namespace App\Repositories;

use App\Models\File;

class FileRepository 
{
    private $model;

    public function __construct(File $model)
    {
        $this->model = $model;
    }

    public function store($data)
    {
        $file = $this->model->create($data);
        return $file;
    }
}