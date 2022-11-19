<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class LoginResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    #[ArrayShape([
        'success' => "bool",
        'token' => "string",
    ])]
    public function toArray($request): array
    {
        return [
            'success' => true,
            'token' => $this->resource,
        ];
    }
}
