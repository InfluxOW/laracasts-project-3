<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AchievementsCreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'achievements:create {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new Achievement class stub';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $class = $this->argument('name');
        $stub = str_replace('{{CLASS}}', $class, file_get_contents(app_path('Achievements/achievement.stub')));
        file_put_contents(app_path('Achievements/' .  $class . '.php'), $stub);

        $this->info("<options=bold;bg=cyan>Achievement {$class} has been created!</>");
    }
}
