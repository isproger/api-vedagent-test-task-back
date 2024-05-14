<?php

use App\Models\ProductType;
use App\Models\TransportCompany;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('calculations', function (Blueprint $table) {
            $table->id();
            $table->float('summ');

            $table->foreignIdFor(TransportCompany::class);
            $table->foreignIdFor(ProductType::class);

            $table->integer('weight_kg');
            $table->integer('distance_km');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculations');
    }
};
