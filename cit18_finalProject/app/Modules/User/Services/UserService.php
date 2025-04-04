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
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        
        return User::create($data);
    }

    public function updateUser(User $user, array $data)
    {
        return $user->update($data);
    }

    public function deleteUser(User $user)
    {
        return $user->delete();
    }

    public function updateProfile(User $user, array $data)
    {
        return $user->update(array_filter($data, fn($value) => 
            $value !== null && $value !== ''
        ));
    }
}
