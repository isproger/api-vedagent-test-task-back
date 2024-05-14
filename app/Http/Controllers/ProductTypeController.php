<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductTypeCollection;
use App\Services\ProductTypeService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductTypeController extends Controller
{
    public function __construct(
        protected ProductTypeService $service
    ){}

    public function getList(): AnonymousResourceCollection
    {
        $transportCompanies = $this->service->getList();
        return ProductTypeCollection::collection($transportCompanies);
    }
}
