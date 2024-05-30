<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                // Create Sample Dummy Users Array
                $products = [
                    [
                        'name'=>'One plus',
                        'productID'=>'mal001',
                        'available_stocks'=> 10,
                        'price'=>100,
                        'tax'=>5,

                    ],
                    [
                        'name'=>'Samsung',
                        'productID'=>'mal002',
                        'available_stocks'=> 15,
                        'price'=>200,
                        'tax'=>10,
                    ],
                    [
                        'name'=>'Redmi',
                        'productID'=>'mal003',
                        'available_stocks'=> 20,
                        'price'=>300,
                        'tax'=>15,
                    ],
                    [
                        'name'=>'Apple',
                        'productID'=>'mal004',
                        'available_stocks'=> 25,
                        'price'=>400,
                        'tax'=>20,
                    ],
                    [
                        'name'=>'Vivo',
                        'productID'=>'mal005',
                        'available_stocks'=> 30,
                        'price'=>500,
                        'tax'=>25,
                    ]
                ];
        
                // Looping and Inserting Array's Users into User Table
                foreach($products as $product){
                    Product::create($product);
                }
        
    }
}
