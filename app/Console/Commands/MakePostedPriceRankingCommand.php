<?php

namespace App\Console\Commands;

use App\Models\TradeRankingModel;
use Illuminate\Console\Command;

class MakePostedPriceRankingCommand extends CommandBase
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:posted-price-ranking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make posted land price ranking to tbl_trade_ranking';

    const POSTED_LAND_PRICE = 2;
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

            $this->myEcho(' Start: Make tbl_trade_ranking table.');

            $this->makeRanking();

            $this->myEcho(' End: Make tbl_trade_ranking table.');

            self::$errorInfo = 1;
        } catch (\Throwable $e) {
            $this->myEcho($e->getTraceAsString());

            $this->sendErrorMessage($e->getTraceAsString());

            self::$errorInfo = 1;

            throw($e);
        }
    }

    protected function makeRanking()
    {
        $model = new TradeRankingModel();
        $model->clearTable(self::POSTED_LAND_PRICE);


    }

    protected function sendErrorMessage(string $message)
    {
//        $this->send(self::MAIL_TO, '[make:cpta] failed', '[make:cpta] cron ended in failure\n' . $message);
    }
}
