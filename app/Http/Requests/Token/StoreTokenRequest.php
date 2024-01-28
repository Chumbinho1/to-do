<?php

namespace App\Http\Requests\Token;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreTokenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $usernameColumn = User::getUsernameColumn();

        return [
            'username' => "required|string|max:255|exists:users,$usernameColumn",
            'password' => 'required|string|min:8',
        ];
    }
}
