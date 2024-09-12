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
                'category_id' => 1,
                'price' => 20000,
                'stock' => 10,
                'image' => 'menus/PTR6hs64GcwPQLLCWRC7DsRTeFi2HDeg4pP3AT94.jpg',
                'description' => 'Nasi goreng special pake telor'
            ],

            [
                'name' => 'Rendang',
                'category_id' => 1, // Masakan Padang
                'price' => 35000,
                'stock' => 15,
                'image' => 'menus/VXMeype3B5uTA78YgMkwCssiBSpbMiEUXCm5tOJ1.jpg',
                'description' => 'Daging sapi yang dimasak lama dengan santan dan rempah-rempah'
            ],
            [
                'name' => 'Sate Ayam',
                'category_id' => 1, // Sate
                'price' => 15000,
                'stock' => 12,
                'image' => 'menus/T8aYmq0Se8zb0S2Ajgo5uhf85UTxxZG5H5uRrrdD.jpg',
                'description' => 'Daging ayam yang ditusuk dan dibakar, disajikan dengan saus kacang'
            ],
            [
                'name' => 'Soto Betawi',
                'category_id' => 1, // Masakan Betawi
                'price' => 20000,
                'stock' => 10,
                'image' => 'menus/bhWkOSJo9IWqKqyG8Y1JmUty3xnwEnktp2Sjdrlz.webp',
                'description' => 'Sup daging sapi dan jeroan dengan kuah santan dan rempah-rempah'
            ],
            [
                'name' => 'Gado-gado',
                'category_id' => 1, // Salad
                'price' => 18000,
                'stock' => 8,
                'image' => 'menus/nKGZEpKvhUapwRQdxDIeLQf0t8lfhSHSZ0hNbTHf.webp',
                'description' => 'Salad sayur dengan saus kacang'
            ],
            [
                'name' => 'Bakso',
                'category_id' => 1, // Bakso
                'price' => 12000,
                'stock' => 15,
                'image' => 'menus/oHdRsWVJ2d7OHV2bi8WziUBOyffpSCubI1dZTrMI.jpg',
                'description' => 'Bola daging cincang yang disajikan dengan kuah kaldu'
            ],
            [
                'name' => 'Pempek',
                'category_id' => 1, // Palembang
                'price' => 10000,
                'stock' => 20,
                'image' => 'menus/toyXtoPEMzpSD20K5NPm0Wkr55CXvMYnHt31avJF.jpg',
                'description' => 'Olahan ikan yang digoreng dengan tepung'
            ],


            // Minuman
            [
                'name' => 'Es Teh',
                'category_id' => 2,
                'price' => 5000,
                'stock' => 10,
                'image' => 'menus/WBZTGvrnlzQMb6AZd7ic00Nm3YLn4Xlqzf6epr7h.png',
                'description' => 'Es teh dengan daun teh pucuk pilihan'
            ],
            [
                'name' => 'Es Jeruk',
                'category_id' => 2,
                'price' => 5000,
                'stock' => 10,
                'image' => 'menus/kKKjXGoakT4KAvj3LtC78Ntyzb0KPJrPUoVgBaeh.jpg',
                'description' => 'Es jeruk yang dibuat dengan bahan dasar jeruk mandarin'
            ],
            [
                'name' => 'Es Cincau',
                'category_id' => 2,
                'price' => 5000,
                'stock' => 10,
                'image' => 'menus/cWXXUx0LErmT97gNz2PFBl053iJXyf8CoyDEUoKE.webp',
                'description' => 'Es cincau yang diolah dengan daun cincau pilihan'
            ],
            [
                'name' => 'Es Kopi',
                'category_id' => 2,
                'price' => 5000,
                'stock' => 10,
                'image' => 'menus/p16kOvt2cCm3r3UFkgZ3PXwFSKJT3gS7HOHzYUU8.webp',
                'description' => 'Kopi special yang dibuat dengan kopi americano pilihan'
            ],


            // Dessert
            [
                'name' => 'Kue Kacang',
                'category_id' => 3,
                'price' => 15000,
                'stock' => 10,
                'image' => 'menus/GimGqbeGE2ZabpSYtGwnBM2RyPKYVPqfeHKBr5cU.jpg',
                'description' => 'Kue kacang dengan rasa gurih dan manis yang khas, dibuat dengan bahan-bahan pilihan.'
            ],
            [
                'name' => 'Es Krim Vanila',
                'category_id' => 3,
                'price' => 20000,
                'stock' => 20,
                'image' => 'menus/TKlYlVpg777i01L8aHkivMv6ORFEGQef55z3Ugol.jpg',
                'description' => 'Es krim vanila yang lembut dengan rasa vanila yang kaya dan manis.'
            ],
            [
                'name' => 'Puding Coklat',
                'category_id' => 3,
                'price' => 18000,
                'stock' => 15,
                'image' => 'menus/6AL1sAtb3b19LWkbmxHll5HUBl9f27lqLFzGGztP.jpg',
                'description' => 'Puding coklat yang lembut dengan rasa coklat yang kaya dan tekstur yang halus.'
            ],
            [
                'name' => 'Kue Susu',
                'category_id' => 3,
                'price' => 15000,
                'stock' => 10,
                'image' => 'menus/AR9wW2wERR7x9FHiquQorV7cNIiHeg2BHSFUfK7y.jpg',
                'description' => 'Kue susu dengan rasa susu yang lembut dan manis.'
            ],
            [
                'name' => 'Cheesecake Strawberry',
                'category_id' => 3,
                'price' => 30000,
                'stock' => 8,
                'image' => 'menus/529SWfdXlZSKPByMrzozZvN0qjSPRbQw2zbgjtxY.jpg',
                'description' => 'Cheesecake dengan topping strawberry segar dan rasa yang lembut dan creamy.'
            ],
            [
                'name' => 'Es Krim Coklat',
                'category_id' => 3,
                'price' => 20000,
                'stock' => 20,
                'image' => 'menus/MkAy2YtUPxdnnsdBZffe52sE9qxbCRUB4V1zRmXO.jpg',
                'description' => 'Es krim coklat yang lembut dengan rasa coklat yang kaya dan manis.'
            ],
            [
                'name' => 'Tiramisu',
                'category_id' => 3,
                'price' => 35000,
                'stock' => 7,
                'image' => 'menus/iojEQE7bGDClC4eJRr1ETOHimGscAOOnjcbBAlvR.jpg',
                'description' => 'Tiramisu klasik dengan lapisan krim mascarpone, kopi, dan bubuk kakao.'
            ],
            [
                'name' => 'Puding Mangga',
                'category_id' => 3,
                'price' => 18000,
                'stock' => 15,
                'image' => 'menus/cyzWnHRHS7KDm1fEvviO0PZe5EvKxF8OhZpPZLbc.webp',
                'description' => 'Puding mangga yang lembut dengan rasa mangga yang segar dan manis.'
            ],
            [
                'name' => 'Brownies Coklat',
                'category_id' => 3,
                'price' => 25000,
                'stock' => 10,
                'image' => 'menus/eC0O98MfcioEdbFVG8hf9moYALqvJ2TFZZXFEQdg.webp',
                'description' => 'Brownies coklat yang kaya rasa dengan tekstur lembut dan padat.'
            ],
            [
                'name' => 'Es Krim Stroberi',
                'category_id' => 3,
                'price' => 20000,
                'stock' => 20,
                'image' => 'menus/GjxLqVr0lX1aoWdk4QDpcnhvPWr4Ije4MIkHR2Yz.jpg',
                'description' => 'Es krim stroberi dengan potongan buah stroberi segar dan rasa yang menyegarkan.'
            ]

        ]);
    }
}
