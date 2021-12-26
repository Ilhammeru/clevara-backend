<?php

namespace Database\Seeders;

use App\Models\Courier;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductPrice;
use App\Models\ProductPromo;
use App\Models\Promo;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();

        try {
            
            $data = [
                [
                    'name' => 'Keran Air Hitam WEIN GH60777HHDG 1455'
                ],
                [
                    'name' => 'Water Heater Panasonic DH-125-2021-574-DEW'
                ],
                [
                    'name' => 'Aquaproof Pail 20kg'
                ],
                [
                    'name' => 'Closed Duduk Toto CW422J / 893565 HDFK'
                ],
                [
                    'name' => 'Bathtub Toto PJY1886HPWMNE'
                ],
                [
                    'name' => 'Wine Cellar Modena SCUDERIA'
                ],
                [
                    'name' => 'Exhaust Fan KDK 60GTC'
                ],
                [
                    'name' => 'Kulkas Modena RETRO - RF 2332'
                ],
                [
                    'name' => 'Kulkas Modena ARGENTO - RF'
                ],
                [
                    'name' => 'Freestanding Modena PRIMA - FC'
                ],
                [
                    'name' => 'Kompor Modena COMBINATO'
                ],
                [
                    'name' => 'Sink Modena MAGGIORE - KS'
                ],
            ];
            Product::insert($data);
    
            // input price
            $price = [
                [
                    'product_id'    => 1,
                    'price'         => 998100
                ],
                [
                    'product_id'    => 2,
                    'price'         => 2321700
                ],
                [
                    'product_id'    => 3,
                    'price'         => 830000
                ],
                [
                    'product_id'    => 4,
                    'price'         => 1740000
                ],
                [
                    'product_id'    => 5,
                    'price'         => 137625000
                ],
                [
                    'product_id'    => 6,
                    'price'         => 130725000
                ],
                [
                    'product_id'    => 7,
                    'price'         => 17534300
                ],
                [
                    'product_id'    => 8,
                    'price'         => 26000000
                ],
                [
                    'product_id'    => 9,
                    'price'         => 10000000
                ],
                [
                    'product_id'    => 10,
                    'price'         => 9640000
                ],
                [
                    'product_id'    => 11,
                    'price'         => 8640000
                ],
                [
                    'product_id'    => 12,
                    'price'         => 6000000
                ]
            ];
            ProductPrice::insert($price);
    
            // product image
            $image = [
                [
                    'product_id'    => 1,
                    'file_url'      => 'tap',
                    'folder'        => 'bestseller'
                ],
                [
                    'product_id'    => 2,
                    'file_url'      => 'waterheater',
                    'folder'        => 'bestseller'
                ],
                [
                    'product_id'    => 3,
                    'file_url'      => 'aquaproof',
                    'folder'        => 'bestseller'
                ],
                [
                    'product_id'    => 4,
                    'file_url'      => 'closet',
                    'folder'        => 'bestseller'
                ],
                [
                    'product_id'    => 5,
                    'file_url'      => 'bathtub',
                    'folder'        => 'promo'
                ],
                [
                    'product_id'    => 6,
                    'file_url'      => 'wine-cellar',
                    'folder'        => 'promo'
                ],
                [
                    'product_id'    => 7,
                    'file_url'      => 'exhaust',
                    'folder'        => 'promo'
                ],
                [
                    'product_id'    => 8,
                    'file_url'      => 'refrigator',
                    'folder'        => 'promo'
                ],
                [
                    'product_id'    => 9,
                    'file_url'      => 'refrigator',
                    'folder'        => 'current'
                ],
                [
                    'product_id'    => 10,
                    'file_url'      => 'modena',
                    'folder'        => 'current'
                ],
                [
                    'product_id'    => 11,
                    'file_url'      => 'stove',
                    'folder'        => 'current'
                ],
                [
                    'product_id'    => 12,
                    'file_url'      => 'sink',
                    'folder'        => 'current'
                ]
            ];
    
            ProductImage::insert($image);
    
            // promo
            $promo = [
                'name'  => 'promo 1',
                'value' => 400000,
                'start_date'    => '2021-12-25',
                'end_date'      => '2022-01-01',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ];
            Promo::insert($promo);

            $productPromo = [
                [
                    'product_id'    => 5,
                    'promo_id'      => 1
                ],
                [
                    'product_id'    => 6,
                    'promo_id'      => 1
                ],
                [
                    'product_id'    => 7,
                    'promo_id'      => 1
                ],
                [
                    'product_id'    => 8,
                    'promo_id'      => 1
                ]
            ];

            ProductPromo::insert($productPromo);

            // customer data
            $customer = [
                'name'      => 'Ilham Meru Gumilang',
                'address'   => 'Jl. Baitis Salmah no 78, Ciputat, Tangerang Selatan',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now()
            ];

            Customer::insert($customer);

            // courier
            $courier = [
                [
                    'name'      => 'JNE NEXT DAY',
                    'price'     => '88000',
                    'estimation'=> '1'
                ],
                [
                    'name'      => 'JNE REGULAR',
                    'price'     => '22000',
                    'estimation'=> '3'
                ],
                [
                    'name'      => 'JNE NEXT DAY',
                    'price'     => '18000',
                    'estimation'=> '2'
                ],
            ];

            Courier::insert($courier);

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            echo $th->getMessage();
        }

    }
}
