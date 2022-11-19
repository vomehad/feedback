<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     description="Инфо заявки",
 *     type="object",
 *     title="FeedbackResponse",
 * )
 */
class FeedbackItem
{
    /**
     * @OA\Property(property="id", type="int", example="1", description="Идентификатор")
     *
     * @var string
     */
    public string $id;

    /**
     * @OA\Property(property="name", type="string", example="ООО 'Луч'", description="Имя Клиента")
     *
     * @var string
     */
    public string $name;
}
