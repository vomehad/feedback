<?php

namespace App\Http\Resources;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class FeedbackResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    #[ArrayShape([
        'id' => "int|mixed",
        'name' => "mixed|string",
        'message' => "mixed|string",
        'processed' => "bool|mixed",
        'user' => UserResponse::class,
        'deleted_at' => "string|mixed",
        'created_at' => "string|mixed",
        'updated_at' => "string|mixed"
    ])] public function toArray($request): array
    {
        /** @var Feedback $this */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'message' => $this->message,
            'processed' => $this->processed,
            'user' => new UserResponse($this->user),
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
