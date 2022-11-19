<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     description="Создание нового отзыва",
 *     type="object",
 *     title="FeedbackCreateRequest",
 *     required={"name", "phone", "message"}
 * )
 */
class FeedbackStoreRequest
{
    /**
     * @OA\Property(property="name", type="string", example="Тест", description="Имя отзыва")
     *
     * @var string
     */
    public string $name;

    /**
     * @OA\Property(property="phone", description="Номер телефона", type="string", example="9955959595")
     *
     * @var string
     */
    public string $phone;

    /**
     * @OA\Property(property="message", description="Сообщение", type="string", example="Тест")
     *
     * @var string
     */
    public string $message;
}
