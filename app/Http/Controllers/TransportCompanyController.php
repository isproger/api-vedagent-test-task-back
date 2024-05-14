<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransportCompanyCollection;
use App\Services\TransportCompanyService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TransportCompanyController extends Controller
{
    public function __construct(
        protected TransportCompanyService $service
    ){}

    public function getList(): AnonymousResourceCollection
    {
        $transportCompanies = $this->service->getList();
        return TransportCompanyCollection::collection($transportCompanies);
    }
}
