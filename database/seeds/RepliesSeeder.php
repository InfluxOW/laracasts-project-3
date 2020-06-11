<?php

use App\User;
use App\Reply;
use App\Thread;
use Illuminate\Database\Seeder;

class RepliesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Reply::class, 100)->create(['thread_id' => Thread::all()->random(), 'user_id' => User::all()->random()]);
    }
}
