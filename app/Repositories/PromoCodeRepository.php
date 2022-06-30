<?php

namespace App\Repositories;

use App\Models\PromotionCode;

class PromoCodeRepository 
{
    private $model;

    public function __construct(PromotionCode $model)
    {
        $this->model = $model;
    }

    public function get($params = [])
    {
        $promotionCodes = $this->model
            ->when(!empty($params['with']), function ($query) use ($params){
                return $query->with($params['with']);
            })
            ->when(!empty($params['order']), function ($query) use ($params){
                return $query->orderByRaw($params['order']);
            });

        if (!empty($params['pagination'])) {
            return $promotionCodes->paginate($params['pagination'], ['*'], isset($params['pagination_name']) ? $params['pagination_name'] : 'page');
        }

        return $promotionCodes->get();
    }

    public function findByColumn($value, $column)
    {
        return $this->model->where($column, $value)->first();
    }

    public function store(PromotionCode $promotionCode)
    {
        $promotionCode->save();

        return $promotionCode;
    }

}