<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class FaultResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    #[ArrayShape([
        'success' => "false",
        'message' => "string",
    ])] public function toArray($request): array
    {
        return [
            'success' => false,
            'message' => $this->resource,
        ];
    }
}
