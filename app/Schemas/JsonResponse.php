<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     description="Success answer",
 *     type="object",
 *     title="success"
 * )
 */
class JsonResponse
{
    /**
     * @OA\Property(property="success", format="bool", example=true)
     *
     * @var bool
     */
    public bool $success;

    /**
     * @OA\Property(property="message", format="string")
     *
     * @var string
     */
    public string $message;
}
