<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     description="Обновление отзыва",
 *     type="object",
 *     title="FeedbackUpdateRequest",
 *     required={"id", "name", "phone", "message"}
 * )
 */
class FeedbackUpdateRequest
{
    /**
     * @OA\Property(property="id", type="int", description="Идентификатор отзыва")
     *
     * @var int
     */
    public int $id;

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
