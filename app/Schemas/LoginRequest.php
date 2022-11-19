<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     description="Авторизоваться в системе",
 *     type="object",
 *     title="LoginRequest",
 *     required={"email", "password"}
 * )
 */
class LoginRequest
{
    /**
     * @OA\Property(property="email", type="string", example="admin@mail.test", description="Email")
     *
     * @var string
     */
    public string $email;

    /**
     * @OA\Property(property="password", type="string", description="Пароль входа в систему", example="test")
     *
     * @var string
     */
    public string $password;
}
