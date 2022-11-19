<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     description="Failed answer",
 *     type="object",
 *     title="falied"
 * )
 */
class JsonFaultResponse
{
    /**
     * @OA\Property(property="success", format="bool", example=false)
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
