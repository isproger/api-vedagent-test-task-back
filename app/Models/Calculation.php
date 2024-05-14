<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calculation extends Model
{
    protected $fillable = [
        "title",
        "summ",
        "transport_company_id",
        "product_type_id",
        "weight_kg",
        "distance_km"
    ];
}
