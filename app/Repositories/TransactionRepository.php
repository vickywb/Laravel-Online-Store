<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository 
{
    private $model;

    public function __construct(Transaction $model)
    {
        $this->model = $model;
    }

    public function get($params = [])
    {
        $transactions = $this->model
            ->when(!empty($params['with']), function ($query) use ($params){
                return $query->with($params['with']);
            })
            ->when(!empty($params['total']), function ($query) use ($params){
                return $query->where($params['total']);
            })
            ->when(!empty($params['name']), function ($query) use ($params){
                return $query->where($params['name']);
            })
            ->when(!empty($params['order']), function ($query) use ($params){
                return $query->orderByRaw($params['order']);
            });

        if (!empty($params['pagination'])) {
            return $transactions->paginate($params['pagination'], ['*'], isset($params['pagination_name']) ? $params['pagination_name'] : 'page');
        }

        return $transactions->get();
    }

    public function findByColumn($value, $column)
    {
        return $this->model->where($column, $value)->first();
    }

    public function store(Transaction $transaction)
    {
        $transaction->save();

        return $transaction;
    }

}