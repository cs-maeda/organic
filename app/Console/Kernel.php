<?php

namespace App\Console;

use App\Console\Commands\ClearPostedLandPrice;
use App\Console\Commands\ClearTradeRanking;
use App\Console\Commands\ImportPostedLandPrice;
use App\Console\Commands\MakeRankingCommand;
use App\Console\Commands\MakeTradeCountCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        MakeRankingCommand::class,
        MakeTradeCountCommand::class,
        ImportPostedLandPrice::class,
        ClearPostedLandPrice::class,
        ClearTradeRanking::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
