<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ShopId' => $this->id,
            'ShopName' => $this->shop_name,
            'MobileNo' => $this->mobile_no,
            'ShopCode' => $this->shop_code,
            'ShopAddress' => $this->address

        ];
    }
}