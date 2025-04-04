<?php

namespace App\Modules\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public const PROFILE_FIELDS = [
        'name',
        'email',
        'contact',
        'date_of_birth',
        'gender',
        'address',
        'role'
    ];

    public const ADMIN_FIELDS = [
        'role',
        'password'
    ];

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $userId = $this->route('user')?->id ?? auth()->id();
        $isAdminRoute = $this->is('admin/*');
        
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $userId],
            'contact' => ['nullable', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:male,female,other'],
            'address' => ['nullable', 'string'],
            'role' => ['sometimes', 'required', 'in:patient,doctor'],
        ];

        if ($isAdminRoute && $this->isMethod('POST')) {
            $rules['password'] = ['required', 'string', 'min:8'];
            $rules['role'] = ['required', 'in:admin,user'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'This email is already taken',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'role.required' => 'Role is required',
            'role.in' => 'Role must be either patient or doctor',
            'gender.in' => 'Invalid gender selected',
        ];
    }

    public function validatedFields(): array
    {
        $fields = self::PROFILE_FIELDS;
        
        if ($this->is('admin/*')) {
            $fields = array_merge($fields, self::ADMIN_FIELDS);
        }

        return $this->only($fields);
    }
}
