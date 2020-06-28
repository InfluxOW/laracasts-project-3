<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if ($this->command->confirm('Do you want to refresh the database?')) {
            $this->command->call('migrate:refresh');
            $this->command->info('Database has been refreshed');
        }

        Cache::flush();
        visits('App\Thread')->reset();

        $this->call([
                UsersSeeder::class,
                ThreadsSeeder::class,
                RepliesSeeder::class,
                ChannelsSeeder::class
            ]);
    }
}
