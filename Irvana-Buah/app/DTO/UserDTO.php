<?php

namespace App\DTO;

use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;

readonly class UserDTO
{
    public function __construct(
        public string  $name,
        public string  $email,
        public string  $role,
        public ?string $password,
        public ?string $phoneNumber,
        public ?string $address,
    ) {}

    public static function fromStoreRequest(StoreUserRequest $request): self
    {
        return new self(
            name:        $request->validated('name'),
            email:       $request->validated('email'),
            role:        $request->validated('role'),
            password:    $request->validated('password'),
            phoneNumber: $request->validated('phone_number'),
            address:     $request->validated('address'),
        );
    }

    public static function fromUpdateRequest(UpdateUserRequest $request): self
    {
        return new self(
            name:        $request->validated('name'),
            email:       $request->validated('email'),
            role:        $request->validated('role'),
            password:    $request->validated('password'),
            phoneNumber: $request->validated('phone_number'),
            address:     $request->validated('address'),
        );
    }
}
