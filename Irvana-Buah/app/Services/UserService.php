<?php

namespace App\Services;

use App\DTO\UserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function createUser(UserDTO $userData): User
    {
        return User::create([
            'name'         => $userData->name,
            'email'        => $userData->email,
            'password'     => Hash::make($userData->password),
            'role'         => $userData->role,
            'phone_number' => $userData->phoneNumber,
            'address'      => $userData->address,
        ]);
    }

    public function updateUser(User $user, UserDTO $userData): User
    {
        $updateData = [
            'name'         => $userData->name,
            'email'        => $userData->email,
            'role'         => $userData->role,
            'phone_number' => $userData->phoneNumber,
            'address'      => $userData->address,
        ];

        if ($userData->password) {
            $updateData['password'] = Hash::make($userData->password);
        }

        $user->update($updateData);
        return $user->fresh();
    }

    public function deleteUser(User $user): void
    {
        $user->delete();
    }
}
