<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     description="Массив сообщений об ошибках",
 *     type="object",
 *     title="faliedValidation"
 * )
 */
class JsonFaultValidation
{
    /**
     * @OA\Property(property="success", format="bool", example=false)
     *
     * @var bool
     */
    public bool $success;

    /**
     * @OA\Property(
     *     property="errors",
     *     format="array",
     *     @OA\Items(
     *         @OA\Property(property="Название поля", type="array", @OA\Items(type="string", example="Cообщение об ошибке")),
     *     )
     * )
     *
     * @var array
     */
    public array $message;
}
