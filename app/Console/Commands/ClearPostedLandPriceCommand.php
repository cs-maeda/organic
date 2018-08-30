<?php

namespace App\Console\Commands;

use App\Models\PostedLandPriceModel;
use Illuminate\Console\Command;

class ClearPostedLandPriceCommand extends CommandBase
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:posted-land-price';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear tbl_posted_land_price table.';

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

            $this->myEcho(' Start: Truncate table tbl_posted_land_price.');

            PostedLandPriceModel::truncate();

            $this->myEcho(' End: Truncate table tbl_posted_land_price.');

            self::$errorInfo = 1;
        } catch (\Throwable $e) {
            $this->myEcho($e->getTraceAsString());

            $this->sendErrorMessage($e->getTraceAsString());

            self::$errorInfo = 1;

            throw($e);
        }
    }

    protected function sendErrorMessage(string $message)
    {
//        $this->send(self::MAIL_TO, '[make:cpta] failed', '[make:cpta] cron ended in failure\n' . $message);
    }
}
