<?php

namespace App\Http\Requests;

use App\Rules\RussianPhoneRule;
use JetBrains\PhpStorm\ArrayShape;

class UpdateFeedbackRequest extends ApiRequest
{
    #[ArrayShape([
        'id' => "int",
        'name' => "string",
        'phone' => "array",
        'message' => "string",
    ])]
    public function rules(): array
    {
        return [
            'id' => $this->getIdRules('feedbacks'),
            'name' => 'required|string|min:3|max:255',
            'phone' => [
                'required',
                app(RussianPhoneRule::class),
            ],
            'message' => 'required|string|min:3|max:255',
        ];
    }
}
