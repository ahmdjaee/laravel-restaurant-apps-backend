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
                'category_id' => 4,
                'price' => 20000,
                'stock' => 10,
                'image' => 'https://www.chilipeppermadness.com/wp-content/uploads/2020/11/Nasi-Goreng-Indonesian-Fried-Rice-SQ.jpg',
                'description' => 'Nasi goreng dengan bumbu kacang'
            ],

            [
                'name' => 'Rendang',
                'category_id' => 4, // Masakan Padang
                'price' => 35000,
                'stock' => 15,
                'image' => 'https://www.astronauts.id/blog/wp-content/uploads/2023/03/Resep-Rendang-Daging-Sapi-Untuk-Lebaran-Gurih-dan-Nikmat-1024x683.jpg',
                'description' => 'Daging sapi yang dimasak lama dengan santan dan rempah-rempah'
            ],
            [
                'name' => 'Sate Ayam',
                'category_id' => 4, // Sate
                'price' => 15000,
                'stock' => 12,
                'image' => 'https://asset.kompas.com/crops/96rHbnDkTGNa8Y-xW247623hONA=/0x0:1000x667/750x500/data/photo/2023/12/19/6580e31d4d33e.jpeg',
                'description' => 'Daging ayam yang ditusuk dan dibakar, disajikan dengan saus kacang'
            ],
            [
                'name' => 'Soto Betawi',
                'category_id' => 4, // Masakan Betawi
                'price' => 20000,
                'stock' => 10,
                'image' => 'https://d1vbn70lmn1nqe.cloudfront.net/prod/wp-content/uploads/2023/08/03072041/Resep-Soto-Betawi-Daging-Tanpa-Santan-Pas-untuk-Menu-Harian-.jpg.webp',
                'description' => 'Sup daging sapi dan jeroan dengan kuah santan dan rempah-rempah'
            ],
            [
                'name' => 'Gado-gado',
                'category_id' => 4, // Salad
                'price' => 18000,
                'stock' => 8,
                'image' => 'https://lingkar.news/wp-content/uploads/2023/04/Resep-Gado-Gado-Betawi-Hidangan-Buka-Puasa-Bergizi-dan-Nikmat.jpg',
                'description' => 'Salad sayur dengan saus kacang'
            ],
            [
                'name' => 'Bakso',
                'category_id' => 4, // Bakso
                'price' => 12000,
                'stock' => 15,
                'image' => 'https://paxelmarket.co/wp-content/uploads/2022/02/Bakso-Komplit.jpg',
                'description' => 'Bola daging cincang yang disajikan dengan kuah kaldu'
            ],
            [
                'name' => 'Pempek',
                'category_id' => 4, // Palembang
                'price' => 10000,
                'stock' => 20,
                'image' => 'https://lingkar.news/wp-content/uploads/2023/03/Aneka-Resep-Pempek-Makanan-Tradisional-Khas-Palembang.jpg',
                'description' => 'Enakkan ikan yang digoreng dengan tepung'
            ],


            // Minuman
            [
                'name' => 'Es Teh',
                'category_id' => 5,
                'price' => 5000,
                'stock' => 10,
                'image' => 'https://asset.kompas.com/crops/vX_ULbw0h4h-CclfUmCXhfjxwTU=/0x0:880x587/750x500/data/photo/2023/08/16/64dc53ca9f3db.jpg',
                'description' => 'Es teh'
            ],
            [
                'name' => 'Es Jeruk',
                'category_id' => 5,
                'price' => 5000,
                'stock' => 10,
                'image' => 'https://d1vbn70lmn1nqe.cloudfront.net/prod/wp-content/uploads/2023/03/09062214/X-Manfaat-Es-Jeruk-dan-Resep-untuk-Membuatnya.jpg',
                'description' => 'Es jeruk'
            ],
            [
                'name' => 'Es Cincau',
                'category_id' => 5,
                'price' => 5000,
                'stock' => 10,
                'image' => 'https://cdn0-production-images-kly.akamaized.net/odquRJ7gUHLSKdigzmLi9QchHQI=/0x0:662x883/469x625/filters:quality(75):strip_icc():format(webp)/kly-media-production/medias/4382480/original/095965700_1680582742-shutterstock_2283035963.jpg',
                'description' => 'Es cincau'
            ],
            [
                'name' => 'Es Kopi',
                'category_id' => 5,
                'price' => 5000,
                'stock' => 10,
                'image' => 'https://kurio-img.kurioapps.com/21/07/06/e0f921c0-97fe-48d6-84ba-60d131b605e9.jpe',
                'description' => 'Es kopi'
            ],


            // Dessert
            [
                'name' => 'Kue Kacang',
                'category_id' => 6,
                'price' => 15000,
                'stock' => 10,
                'image' => 'https://d1vbn70lmn1nqe.cloudfront.net/prod/wp-content/uploads/2022/11/12165826/Resep-Kue-Kacang-Betawi.jpg',
                'description' => 'Kue kacang dengan rasa gurih dan manis yang khas, dibuat dengan bahan-bahan pilihan.'
            ],
            [
                'name' => 'Es Krim Vanila',
                'category_id' => 6,
                'price' => 20000,
                'stock' => 20,
                'image' => 'https://www.hersheys.com/content/dam/sm-fimages/media-center-media/Hersheys/images/products/vanilla-ice-cream.jpg',
                'description' => 'Es krim vanila yang lembut dengan rasa vanila yang kaya dan manis.'
            ],
            [
                'name' => 'Puding Coklat',
                'category_id' => 6,
                'price' => 18000,
                'stock' => 15,
                'image' => 'https://www.masakapahariini.com/wp-content/uploads/2021/06/puding-coklat-780x440.jpg',
                'description' => 'Puding coklat yang lembut dengan rasa coklat yang kaya dan tekstur yang halus.'
            ],
            [
                'name' => 'Kue Susu',
                'category_id' => 6,
                'price' => 15000,
                'stock' => 10,
                'image' => 'https://d1vbn70lmn1nqe.cloudfront.net/prod/wp-content/uploads/2022/11/12165826/Resep-Kue-Kacang-Betawi.jpg',
                'description' => 'Kue susu dengan rasa susu yang lembut dan manis.'
            ],
            [
                'name' => 'Cheesecake Strawberry',
                'category_id' => 6,
                'price' => 30000,
                'stock' => 8,
                'image' => 'https://www.simplyrecipes.com/thmb/5aRtL5ds7v0P6MmcRS7tT68CwWY=/2000x1500/filters:no_upscale():max_bytes(150000):strip_icc()/Simply-Recipes-Strawberry-Cheesecake-LEAD-1-4c3ed5ab0e0748c6b36e2e6a0c301e4f.jpg',
                'description' => 'Cheesecake dengan topping strawberry segar dan rasa yang lembut dan creamy.'
            ],
            [
                'name' => 'Es Krim Coklat',
                'category_id' => 6,
                'price' => 20000,
                'stock' => 20,
                'image' => 'https://www.hersheys.com/content/dam/sm-fimages/media-center-media/Hersheys/images/products/chocolate-ice-cream.jpg',
                'description' => 'Es krim coklat yang lembut dengan rasa coklat yang kaya dan manis.'
            ],
            [
                'name' => 'Tiramisu',
                'category_id' => 6,
                'price' => 35000,
                'stock' => 7,
                'image' => 'https://www.simplyrecipes.com/thmb/CYRU-t8m8JChdoXkV6lS-jyfJK4=/2000x1500/filters:no_upscale():max_bytes(150000):strip_icc()/Simply-Recipes-Tiramisu-LEAD-3-5965f8ed39f9445b93c0db9a8f5f60e0.jpg',
                'description' => 'Tiramisu klasik dengan lapisan krim mascarpone, kopi, dan bubuk kakao.'
            ],
            [
                'name' => 'Puding Mangga',
                'category_id' => 6,
                'price' => 18000,
                'stock' => 15,
                'image' => 'https://www.masakapahariini.com/wp-content/uploads/2021/06/puding-mangga-780x440.jpg',
                'description' => 'Puding mangga yang lembut dengan rasa mangga yang segar dan manis.'
            ],
            [
                'name' => 'Brownies Coklat',
                'category_id' => 6,
                'price' => 25000,
                'stock' => 10,
                'image' => 'https://www.simplyrecipes.com/thmb/NJ4Z6lfVBybMzz5nb7g9Y6xnPv0=/2000x1500/filters:no_upscale():max_bytes(150000):strip_icc()/Simply-Recipes-Brownies-LEAD-3-7d5d469c69dc47efbffef5f9c7d3b7a9.jpg',
                'description' => 'Brownies coklat yang kaya rasa dengan tekstur lembut dan padat.'
            ],
            [
                'name' => 'Es Krim Stroberi',
                'category_id' => 6,
                'price' => 20000,
                'stock' => 20,
                'image' => 'https://www.hersheys.com/content/dam/sm-fimages/media-center-media/Hersheys/images/products/strawberry-ice-cream.jpg',
                'description' => 'Es krim stroberi dengan potongan buah stroberi segar dan rasa yang menyegarkan.'
            ]

        ]);
    }
}
