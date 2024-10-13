<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  App\Models\Brand;
use  App\Models\Material;
use  App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Vytvorenie Znaciek
        $brands = ['Abarth', 'Alfa Romeo', 'Audi', 'BMW', 'Chrysler', 'Volvo', 'Skoda', 'Mercedes-benz'];

        foreach ($brands as $brand)
        {
            Brand :: create(['name' => $brand]);
        }

        //Vytvorenie materialov
        $materials = ['Plast', 'Plech', 'Hliník'];

        foreach ($materials as $material)
        {
            Material :: create(['name' => $material]);
        }

        //Vytvorenie Produktu
        for ($i = 1; $i <= 20; $i++)
        {
            Product :: create ([
                'brand_id' => Brand :: inRandomOrder() -> first() -> id,
                'material_id' => Material :: inRandomOrder() -> first() -> id,
                'code' => 'PM' . str_pad($i, 5, '0, STR_PAD_LEFT'),
                'name' => 'Kryt Motoru' . $i,
                'description' => 'Popis krytu motoru' . $i,
                'price' => rand(1000, 10000),
            ]);
        }

    }
}
