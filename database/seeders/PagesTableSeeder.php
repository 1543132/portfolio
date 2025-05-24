<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Page;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::find(1);

        Page::truncate();

        $admin->pages()->saveMany([
            new Page([
                'title' => 'About',
                'url' => '/about',
                'content' => 'This is about us.'
            ]),
            new Page([
                'title' => 'Contact',
                'url' => '/contact',
                'content' => 'This is contact.'
            ]),
            new Page([
                'title' => 'Another Page',
                'url' => '/another-page',
                'content' => 'This is another page.'
            ]),
        ]);
    }
}
