<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class SuccessResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    #[ArrayShape([
        'success' => "bool",
        'message' => "string",
    ])] public function toArray($request): array
    {
        return [
            'success' => true,
            'message' => $this->resource,
        ];
    }
}
