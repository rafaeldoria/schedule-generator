<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository
{
    public function store(array $data): Customer
    {
        return Customer::query()->create($data);
    }

    public function getById(int $id): ?Customer
    {
        return Customer::query()
            ->where('id', $id)
            ->first();
    }
}
