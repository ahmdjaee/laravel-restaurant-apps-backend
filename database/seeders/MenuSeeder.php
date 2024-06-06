<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::insert([
            [
                'name' => 'Nasi Goreng',
                'category_id' => 2,
                'price' => 20000,
                'stock' => 10,
                'image' => 'https://www.chilipeppermadness.com/wp-content/uploads/2020/11/Nasi-Goreng-Indonesian-Fried-Rice-SQ.jpg',
                'description' => 'Nasi goreng dengan bumbu kacang'
            ],

            [
                'name' => 'Rendang',
                'category_id' => 2, // Masakan Padang
                'price' => 35000,
                'stock' => 15,
                'image' => 'https://www.astronauts.id/blog/wp-content/uploads/2023/03/Resep-Rendang-Daging-Sapi-Untuk-Lebaran-Gurih-dan-Nikmat-1024x683.jpg',
                'description' => 'Daging sapi yang dimasak lama dengan santan dan rempah-rempah'
            ],
            [
                'name' => 'Sate Ayam',
                'category_id' => 2, // Sate
                'price' => 15000,
                'stock' => 12,
                'image' => 'https://asset.kompas.com/crops/96rHbnDkTGNa8Y-xW247623hONA=/0x0:1000x667/750x500/data/photo/2023/12/19/6580e31d4d33e.jpeg',
                'description' => 'Daging ayam yang ditusuk dan dibakar, disajikan dengan saus kacang'
            ],
            [
                'name' => 'Soto Betawi',
                'category_id' => 2, // Masakan Betawi
                'price' => 20000,
                'stock' => 10,
                'image' => 'https://d1vbn70lmn1nqe.cloudfront.net/prod/wp-content/uploads/2023/08/03072041/Resep-Soto-Betawi-Daging-Tanpa-Santan-Pas-untuk-Menu-Harian-.jpg.webp',
                'description' => 'Sup daging sapi dan jeroan dengan kuah santan dan rempah-rempah'
            ],
            [
                'name' => 'Gado-gado',
                'category_id' => 2, // Salad
                'price' => 18000,
                'stock' => 8,
                'image' => 'https://lingkar.news/wp-content/uploads/2023/04/Resep-Gado-Gado-Betawi-Hidangan-Buka-Puasa-Bergizi-dan-Nikmat.jpg',
                'description' => 'Salad sayur dengan saus kacang'
            ],
            [
                'name' => 'Bakso',
                'category_id' => 2, // Bakso
                'price' => 12000,
                'stock' => 15,
                'image' => 'https://paxelmarket.co/wp-content/uploads/2022/02/Bakso-Komplit.jpg',
                'description' => 'Bola daging cincang yang disajikan dengan kuah kaldu'
            ],
            [
                'name' => 'Pempek',
                'category_id' => 2, // Palembang
                'price' => 10000,
                'stock' => 20,
                'image' => 'https://lingkar.news/wp-content/uploads/2023/03/Aneka-Resep-Pempek-Makanan-Tradisional-Khas-Palembang.jpg',
                'description' => 'Enakkan ikan yang digoreng dengan tepung'
            ],


            // Minuman
            [
                'name' => 'Es Teh',
                'category_id' => 3,
                'price' => 5000,
                'stock' => 10,
                'image' => 'https://asset.kompas.com/crops/vX_ULbw0h4h-CclfUmCXhfjxwTU=/0x0:880x587/750x500/data/photo/2023/08/16/64dc53ca9f3db.jpg',
                'description' => 'Es teh'
            ],
            [
                'name' => 'Es Jeruk',
                'category_id' => 3,
                'price' => 5000,
                'stock' => 10,
                'image' => 'https://d1vbn70lmn1nqe.cloudfront.net/prod/wp-content/uploads/2023/03/09062214/X-Manfaat-Es-Jeruk-dan-Resep-untuk-Membuatnya.jpg',
                'description' => 'Es jeruk'
            ],
            [
                'name' => 'Es Cincau',
                'category_id' => 3,
                'price' => 5000,
                'stock' => 10,
                'image' => 'https://cdn0-production-images-kly.akamaized.net/odquRJ7gUHLSKdigzmLi9QchHQI=/0x0:662x883/469x625/filters:quality(75):strip_icc():format(webp)/kly-media-production/medias/4382480/original/095965700_1680582742-shutterstock_2283035963.jpg',
                'description' => 'Es cincau'
            ],
            [
                'name' => 'Es Kopi',
                'category_id' => 3,
                'price' => 5000,
                'stock' => 10,
                'image' => 'https://kurio-img.kurioapps.com/21/07/06/e0f921c0-97fe-48d6-84ba-60d131b605e9.jpe',
                'description' => 'Es kopi'
            ],
        ]);
    }
}
