<?php

namespace App\Services;

use App\Models\TransportCompany;
use Illuminate\Database\Eloquent\Collection;

class TransportCompanyService
{
    public function getList(): Collection
    {
        return TransportCompany::all();
    }
}
