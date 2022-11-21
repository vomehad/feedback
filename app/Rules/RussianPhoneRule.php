<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RussianPhoneRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $pattern = "/(\+?(7|8)\s?\(?\d{3}\)?\s?\d{3}(\s|-)?\d{2}(\s|-)?\d{2})/";
        preg_match($pattern, $value, $match);

        if (empty($match[1])) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('message.errors.phone');
    }
}
