<?php

namespace App\Services;


use App\DTO\CalculationDTO;
use App\Models\Calculation;
use App\Models\TransportCompany;
use Illuminate\Database\Eloquent\Collection;

class CalculationService
{
    public static function getCalculateResult(CalculationDTO $dto): array
    {
        $result = [
            'value'=>0
        ];

        try {
            $transportCompany = TransportCompany::find($dto->transportCompany);
            if(!$transportCompany){
                throw new \BadMethodCallException("TransportCompany with id {$dto->transportCompany} is not found");
            }

            $price = $transportCompany->price;

            if(!$price){
                throw new \BadMethodCallException('price is not found');
            }

            $unitWeightKg = $transportCompany->unit_weight_kg;
            $weight = $dto->weight;
            $weightForCalculate = ($weight < 100) ? 100 : $weight;
            $distance = $dto->distance;
            $distanceForCalculate = $distance;

            $coefficient = $weightForCalculate / $unitWeightKg;

            $priceWithCoeff = $price*$coefficient;

            $result['value'] = $priceWithCoeff*$distanceForCalculate;
            $result['print_value'] = number_format($priceWithCoeff*$distanceForCalculate, 2, '.', ' ');

        }catch (\Throwable $e){
            $result['error'] = $e->getMessage();
        }

        return $result;
    }

    public static function saveCalculation(CalculationDTO $dto): array
    {
        $result = [];

        try {
            $calcResult = static::getCalculateResult($dto);
            if(!$calcResult){
                throw new \BadMethodCallException('system error ....');
            }
            $result['calculation'] = Calculation::create([
                'transport_company_id'=>$dto->transportCompany,
                'product_type_id'=>$dto->productType,
                'weight_kg'=>$dto->weight,
                'distance_km'=>$dto->distance,
                'summ'=>$calcResult['value'],
            ]);
            $result['message'] = 'Расчет успешно сохранен';
        }catch (\Throwable $e){
            $result['error'] = $e->getMessage();
        }


        return $result;
    }

    public function getList(): Collection
    {
        return Calculation::all();
    }
}
