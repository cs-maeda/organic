<?php

namespace App\Console\Commands;

use App\Models\TradeCountModel;
use App\Models\TradeRankingModel;
use App\Models\TradeRecordsModel;
use Illuminate\Console\Command;

class MakeTradeCountCommand extends CommandBase
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:trade_count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make tbl_trade_count table';

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

        try
        {
            self::$errorInfo = 0;

            $this->myEcho(' Start: Make tbl_trade_count table.');

            $this->makeTradeCount();

//            $this->send(self::MAIL_TO, '[make:ranking] successful', '[make:ranking] cron was executed successfully');

            $this->myEcho(' End: Make tbl_trade_count table.');

            self::$errorInfo = 1;
        }
        catch (\Throwable $e)
        {
            $this->myEcho($e->getTraceAsString());

            $this->sendErrorMessage($e->getTraceAsString());

            self::$errorInfo = 1;

            throw($e);
        }
    }

    protected function makeTradeCount()
    {
        $tradeCountModel = new TradeCountModel();
        $tradeCountModel->clearTable();

        for ($prefectureId = 1; $prefectureId <= 47; $prefectureId++){
            $this->importTradeCount('iacs-icc.org', $tradeCountModel, $prefectureId);
        }

        for ($prefectureId = 1; $prefectureId <= 47; $prefectureId++){
            $this->importTradeCount('rhs-inc.com', $tradeCountModel, $prefectureId);
        }
    }

    protected function importTradeCount(string $domainName, TradeCountModel $tradeCountModel, int $prefectureId)
    {
        echo $prefectureId . PHP_EOL;
        $tradeCountModel->importCityTradeCount($domainName, $prefectureId);

        $results = $tradeCountModel->getTradeCount($domainName, $prefectureId);
        foreach ($results as $result){
            echo $prefectureId . ":" . $result['area_id'] . PHP_EOL;
            $this->importTownTradeCount($domainName, $tradeCountModel, $result['area_id']);
            $this->importStationTradeCount($domainName, $tradeCountModel, $result['area_id']);
        }
    }

    protected function importTownTradeCount(string $domainName, TradeCountModel $tradeCountModel, int $cityId)
    {
        $tradeCountModel->importTownTradeCount($domainName, $cityId);
    }

    protected function importStationTradeCount(string $domainName, TradeCountModel $tradeCountModel, int $cityId)
    {
        $tradeCountModel->importStationTradeCount($domainName, $cityId);
    }

    protected function makeJapanAverage(string $domainName, TradeRankingModel $tradeRankingModel)
    {
        $tradeRankingModel->importJapanAverage($domainName);
    }

    protected function sendErrorMessage(string $message)
    {
//        $this->send(self::MAIL_TO, '[make:cpta] failed', '[make:cpta] cron ended in failure\n' . $message);
    }
}
