<?php

namespace App\Dtos;

class CustomerDto
{
    public function __construct(
        public string $fullName,
        public string $email,
        public ?string $cellphone = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'full_name' => $this->fullName,
            'email' => $this->email,
            'cellphone' => $this->cellphone,
        ];
    }

    public function toResponse(int $id): array
    {
        return [
            'full_name' => $this->fullName,
            'email' => $this->email,
            'cellphone' => $this->cellphone,
            'id' => $id,
        ];
    }
}
