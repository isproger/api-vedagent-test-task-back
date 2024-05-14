<?php

namespace App\Services;

use App\Models\ProductType;
use App\Models\TransportCompany;
use Illuminate\Database\Eloquent\Collection;

class ProductTypeService
{
    public function getList(): Collection
    {
        return ProductType::all();
    }
}
