<?php

namespace Database\Seeders;

use App\Models\MainLink;
use Illuminate\Database\Seeder;

class MainLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $links = [
            [
                'name' => 'weblog',
                'name_en' => 'وبلاگ',
                'slug' => 'weblog-2',
                'link' => env('APP_URL') .'/weblog-2',
            ],
            [
                'name' => 'قوانین و مقررات',
                'name_en' => 'site-rules',
                'slug' => 'قوانین-و-مقررات',
                'link' => env('APP_URL') .'/قوانین-و-مقررات',
            ]
        ];

        foreach($links as $link){
            MainLink::create([
                'name' => $link['name'],
                'name_en' => $link['name_en'],
                'slug' => $link['slug'],
                'link' => $link['link'],
            ]);
        }
    }
}
