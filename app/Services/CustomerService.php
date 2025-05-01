<?php

namespace App\Services;

use App\Dtos\CustomerDto;
use App\Repositories\CustomerRepository;

class CustomerService
{
    public function __construct(protected CustomerRepository $repository)
    {
    }

    public function getByid(int $employeeId): array
    {
        $customer = $this->repository->getById($employeeId);

        if (empty($customer)) {
            return [];
        }

        $schedulteDetailsDto = new CustomerDto(
            $customer->full_name,
            $customer->email,
            $customer->cellphone,
        );

        return $schedulteDetailsDto->toResponse($customer->id);
    }
}
