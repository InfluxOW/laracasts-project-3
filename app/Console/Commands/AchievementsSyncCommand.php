<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class AchievementsSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'achievements:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all user achievements in the database';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->output->progressStart(User::count());
        User::chunk(100, function ($users) {
            $this->output->progressAdvance($users->count());
            $users->each->syncAchievements();
        });
        $this->output->progressFinish();

        $this->info("<options=bold;bg=cyan>User achievements have been synced!</>");
    }
}
