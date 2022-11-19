<?php

namespace App\Http\Requests;

use App\Rules\RussianPhoneRule;
use JetBrains\PhpStorm\ArrayShape;

class CreateFeedbackRequest extends ApiRequest
{
    #[ArrayShape([
        'name' => "string",
        'phone' => "array",
        'message' => "string",
    ])]
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'phone' => [
                'required',
                app(RussianPhoneRule::class),
            ],
            'message' => 'required|string|min:3|max:255',
        ];
    }
}
