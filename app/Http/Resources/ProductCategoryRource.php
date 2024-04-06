<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryRource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ProductCategoryId' => $this->ProductCategoryId,
            'ProductCategoryCode' => $this->ProductCategoryCode,
            'ProductName' => $this->ProductName
        ];
    }
}
