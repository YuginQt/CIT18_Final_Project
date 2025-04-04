<?php

namespace App\Modules\User\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
{
    public function getAllUsers()
    {
        return User::all();
    }

    public function createUser(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'contact' => $data['contact'] ?? null,
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'gender' => $data['gender'] ?? null,
            'address' => $data['address'] ?? null,
        ]);
    }

    public function updateUser(User $user, array $data)
    {
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'contact' => $data['contact'] ?? null,
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'gender' => $data['gender'] ?? null,
            'address' => $data['address'] ?? null,
        ]);

        return $user;
    }

    public function deleteUser(User $user)
    {
        return $user->delete();
    }

    public function updateProfile(User $user, array $data)
    {
        $updateData = array_filter([
            'name' => $data['name'],
            'email' => $data['email'],
            'contact' => $data['contact'],
            'date_of_birth' => $data['date_of_birth'],
            'gender' => $data['gender'],
            'address' => $data['address'],
        ], fn($value) => $value !== null && $value !== '');

        return $user->update($updateData);
    }
}
