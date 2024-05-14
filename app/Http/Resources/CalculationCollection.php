<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CalculationCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'transport_company_id' => $this->transport_company_id,
            'product_type_id' => $this->product_type_id,
            'weight_kg' => $this->weight_kg,
            'distance_km' => $this->distance_km,
            'summ' => $this->summ,
        ];
    }
}
