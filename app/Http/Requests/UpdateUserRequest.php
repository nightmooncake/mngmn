<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $user = $this->route('user');
        $userId = is_object($user) ? $user->id : (is_array($user) ? $user['id'] : $user);
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $userId,
            'role' => 'required|string|in:user,admin',
        ];
        // Password opsional, minimal 8 jika diisi
        if ($this->filled('password')) {
            $rules['password'] = 'string|min:8';
        }
        return $rules;
    }
}
