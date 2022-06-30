<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository 
{
    private $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function get($params = [])
    {
        $products = $this->model
            ->when(!empty($params['with']), function ($query) use ($params){
                return $query->with($params['with']);
            })
            ->when(!empty($params['category_id']), function ($query) use ($params) {
                return $query->where('category_id', $params['category_id']);
            })
            ->when(!empty($params['user_id']), function ($query) use ($params){
                return $query->where('user_id', $params['user_id']);
            })
            ->when(!empty($params['order']), function ($query) use ($params){
                return $query->orderByRaw($params['order']);
            });

        if (!empty($params['pagination'])) {
            return $products->paginate($params['pagination'], ['*'], isset($params['pagination_name']) ? $params['pagination_name'] : 'page');
        }

        return $products->get();
    }

    public function findByColumn($value, $column)
    {
        return $this->model->where($column, $value)->first();
    }

    public function store(Product $product)
    {
        $product->save();

        return $product;
    }

}