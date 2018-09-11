<?php

namespace App\Console;

use App\Console\Commands\ClearPostedLandPriceCommand;
use App\Console\Commands\ClearTradeRankingCommand;
use App\Console\Commands\ImportPostedLandPriceCommand;
use App\Console\Commands\MakePostedPriceAverageCommand;
use App\Console\Commands\MakeRankingCommand;
use App\Console\Commands\MakeSitemapCommand;
use App\Console\Commands\MakeStandardPointCountCommand;
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
        ImportPostedLandPriceCommand::class,
        ClearPostedLandPriceCommand::class,
        ClearTradeRankingCommand::class,
        MakePostedPriceAverageCommand::class,
        MakeStandardPointCountCommand::class,
        MakeSitemapCommand::class,
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
