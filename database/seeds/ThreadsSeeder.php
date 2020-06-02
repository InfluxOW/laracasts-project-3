<?php

use App\Thread;
use Illuminate\Database\Seeder;

class ThreadsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Thread::class, 20)->create();
    }
}
