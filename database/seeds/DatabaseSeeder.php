<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            MenuSeeder::class,
            ConfigSeeder::class,
            CategorySeeder::class,
            LinkSeeder::class,
            SlideSeeder::class
        ]);
    }
}
