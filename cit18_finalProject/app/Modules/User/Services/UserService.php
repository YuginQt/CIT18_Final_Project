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
        
        // Ensure role is set
        $data['role'] = $data['role'] ?? 'patient';
        
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
        // Filter out empty values but keep role even if it's the same
        $filteredData = array_filter($data, function($value, $key) {
            if ($key === 'role') return true;
            return $value !== null && $value !== '';
        }, ARRAY_FILTER_USE_BOTH);
        
        return $user->update($filteredData);
    }
}
