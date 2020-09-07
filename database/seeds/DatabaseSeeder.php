<?php

use Illuminate\Database\Seeder;

use Seeds\Base\{
    UserTableSeeder,
    TranslationsTableSeeder,
    TagsTableSeeder,
};

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
