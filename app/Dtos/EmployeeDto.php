<?php

namespace App\Dtos;

readonly class EmployeeDto
{
    public function __construct(
        public string $fullName,
        public string $email,
        public string $function,
        public bool $available,
    ) {
    }

    public function toArray(): array
    {
        return [
            'full_name' => $this->fullName,
            'email' => $this->email,
            'function' => $this->function,
            'available' => $this->available,
        ];
    }
}
