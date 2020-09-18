<?php

declare(strict_types=1);

use Illuminate\Database\Seeder;
use Seeds\Base\TagsTableSeeder;
use Seeds\Base\TranslationsTableSeeder;
use Seeds\Base\UserTableSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserTableSeeder::class,
            TranslationsTableSeeder::class,
            TagsTableSeeder::class,
        ]);
    }
}
