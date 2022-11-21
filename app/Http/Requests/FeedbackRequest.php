<?php

namespace App\Http\Requests;

use App\Rules\RussianPhoneRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\ArrayShape;

class FeedbackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape([
        'name' => "string",
        'phone' => "array",
        'message' => "string"
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
