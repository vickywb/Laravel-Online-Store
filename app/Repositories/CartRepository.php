<?php

namespace App\Repositories;

use App\Models\Cart;

class CartRepository 
{
    private $model;

    public function __construct(Cart $model)
    {
        $this->model = $model;
    }

    public function get($params = [])
    {
        $carts = $this->model
            ->when(!empty($params['with']), function ($query) use ($params){
                return $query->with($params['with']);
            })
            ->when(!empty($params['name']), function ($query) use ($params){
                return $query->where($params['name']);
            })
            ->when(!empty($params['user_id']), function ($query) use ($params){
                return $query->where('user_id', $params['user_id']);
            })
            ->when(!empty($params['order']), function ($query) use ($params){
                return $query->orderByRaw($params['order']);
            });

        if (!empty($params['pagination'])) {
            return $carts->paginate($params['pagination'], ['*'], isset($params['pagination_name']) ? $params['pagination_name'] : 'page');
        }

        return $carts->get();
    }

    public function findByColumn($value, $column)
    {
        return $this->model->where($column, $value)->first();
    }

    public function store(Cart $cart)
    {
        $cart->save();

        return $cart;
    }

}