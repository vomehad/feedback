<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     description="Ответ авторизации",
 *     type="object",
 * )
 */
class LoginResponse
{
    /**
     * @OA\Property(property="success", format="bool", example=true)
     *
     * @var bool
     */
    public bool $success;

    /**
     * @OA\Property(property="token", format="string", description="Bearer токен для авторизации")
     *
     * @var string
     */
    public string $token;
}
