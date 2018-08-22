<?php

namespace App\Console\Commands;

use App\Models\PostedLandPriceAverageModel;
use Illuminate\Console\Command;

class MakePostedPriceAverageCommand extends CommandBase
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:posted-average';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make posted land price average with tbl_posted_land_price_average.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->errorTrap();

        try {
            self::$errorInfo = 0;

            $this->myEcho(' Start: Make posted land price average with tbl_posted_land_price_average.');

            $this->makeAverage();

            $this->myEcho(' End: Make posted land price average with tbl_posted_land_price_average.');

            self::$errorInfo = 1;
        } catch (\Throwable $e) {
            $this->myEcho($e->getTraceAsString());

            $this->sendErrorMessage($e->getTraceAsString());

            self::$errorInfo = 1;

            throw($e);
        }
    }

    protected function makeAverage()
    {
        PostedLandPriceAverageModel::truncate();

        $model = new PostedLandPriceAverageModel();
        $model->japanAverage();
        $model->prefectureAverage();
        $model->cityAverage();
    }

    protected function sendErrorMessage(string $message)
    {
//        $this->send(self::MAIL_TO, '[make:cpta] failed', '[make:cpta] cron ended in failure\n' . $message);
    }
}
