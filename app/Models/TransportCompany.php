<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "price",
        "unit_weight_kg",
        "unit_distance_km"
    ];
}
