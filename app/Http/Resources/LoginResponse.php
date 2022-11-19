<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class LoginResponse extends JsonResource
{
    private bool $tempPass;

    #[Pure]
    public function __construct($resource, bool $tempPass = false)
    {
        parent::__construct($resource);
        $this->tempPass = $tempPass;
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    #[ArrayShape([
        'success' => "bool",
        'token' => "string",
        'tempPass' => "bool",
    ])]
    public function toArray($request): array
    {
        return [
            'success' => true,
            'token' => $this->resource,
            'tempPass' => $this->tempPass,
        ];
    }
}
