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
                UsersSeeder::class,
                ThreadsSeeder::class,
                RepliesSeeder::class,
                ChannelsSeeder::class
            ]);
    }
}
