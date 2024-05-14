<?php

namespace App\DTO;


use App\Http\Requests\CalculationRequest;

class CalculationDTO
{
    public int $transportCompany;
    public int $productType;
    public float $weight;
    public float $distance;

    public function __construct(
        CalculationRequest $request,
    ) {
        $this->transportCompany = intval($request->get('transportCompany'));
        $this->productType = intval($request->get('productType'));
        $this->weight = is_numeric($request->get('weight')) ? $request->get('weight')*1 : 0;
        $this->distance = is_numeric($request->get('distance')) ? $request->get('distance')*1 : 0;
    }
}
