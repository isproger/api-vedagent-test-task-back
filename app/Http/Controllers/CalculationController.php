<?php

namespace App\Http\Controllers;

use App\DTO\CalculationDTO;
use App\Http\Requests\CalculationRequest;
use App\Http\Resources\CalculationCollection;
use App\Services\CalculationService;
use App\Services\ProductTypeService;
use App\Services\TransportCompanyService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CalculationController extends Controller
{
    public function __construct(
        protected CalculationService $service,
        protected TransportCompanyService $transportCompanyService,
        protected ProductTypeService $productTypeService,
    ){}

    public function getCalculateResult(CalculationRequest $request): array
    {
        $dto = new CalculationDTO($request);
        return $this->service->getCalculateResult($dto);
    }

    public function saveCalculation(CalculationRequest $request): array
    {
        $dto = new CalculationDTO($request);
        return $this->service->saveCalculation($dto);
    }

    public function getList(): AnonymousResourceCollection
    {
        $calculations = $this->service->getList();
        return CalculationCollection::collection($calculations);
    }

}
