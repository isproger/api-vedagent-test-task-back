<?php

namespace Database\Seeders;

use App\Models\ProductType;
use App\Models\TransportCompany;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $priceList = [25,27,21];

        foreach ($priceList as $key=>$priceItem){
            $num = $key+1;
            TransportCompany::create([
                'title'=>"Transport Company №{$num}",
                'price'=>$priceItem,
                'unit_weight_kg'=>100,
                'unit_distance_km'=>1,
            ]);
        }

        $productTypes = [
            'Промышленное оборудование',
            'Бытовая техника',
            'Посуда, кухонные принадлежности, товары хозяйственобытового назначения',
            'Мебель',
            'Упаковка',
            'Товары легкой промышлености',
            'Косметика',
            'Смазочные материалы и масла',
            'Запчасти для транспортных средств',
            'Средства индивидуальной защиты',
        ];

        foreach ($productTypes as $productType){
            ProductType::create([
                'title'=>$productType,
            ]);
        }
    }
}
