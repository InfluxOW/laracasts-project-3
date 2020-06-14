<?php

use App\Thread;
use App\User;
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
            factory(Thread::class, 24)->create();
    }
}
