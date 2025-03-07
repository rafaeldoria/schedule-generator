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

    public function toResponse(int $id): array
    {
        return [
            'full_name' => $this->fullName,
            'email' => $this->email,
            'function' => $this->function,
            'available' => $this->available,
            'id' => $id,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            fullName: $data['full_name'],
            email: $data['email'],
            function: $data['function'],
            available: $data['available'],
        );
    }
}
