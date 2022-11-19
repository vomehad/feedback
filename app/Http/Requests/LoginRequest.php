<?php

namespace App\Http\Requests;

use App\Http\Requests\ApiRequest;
use JetBrains\PhpStorm\ArrayShape;

class LoginRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape([
        'email' => "string",
        'password' => "string"
    ])] public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => "required",
        ];
    }
}
