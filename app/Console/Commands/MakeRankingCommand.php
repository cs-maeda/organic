<?php

namespace App\Console\Commands;

use App\Models\TradeRankingModel;
use App\Models\TradeRecordsModel;
use Illuminate\Console\Command;

class MakeRankingCommand extends CommandBase
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:ranking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make tbl_trade_ranking table';

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

//            $this->send(self::MAIL_TO, '[make:ranking] successful', '[make:ranking] cron was executed successfully');

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
        $tradeRankingModel = new TradeRankingModel();
        $tradeRankingModel->clearTable();

        $this->makeJapanAverage('iacs-icc.org', $tradeRankingModel);
        $this->makePrefectureRanking('iacs-icc.org', $tradeRankingModel);
        $this->makeCityRanking('iacs-icc.org', $tradeRankingModel);
        $this->makeTownRanking('iacs-icc.org', $tradeRankingModel);
        $this->makeStationRanking('iacs-icc.org', $tradeRankingModel);
    }

    protected function makeJapanAverage(string $domainName, TradeRankingModel $tradeRankingModel)
    {
        $tradeRankingModel->importJapanAverage($domainName);
    }

    protected function makePrefectureRanking(string $domainName, TradeRankingModel $tradeRankingModel)
    {
        $tradeRankingModel->importPrefectureRanking($domainName);
    }

    protected function makeCityRanking(string $domainName, TradeRankingModel $tradeRankingModel)
    {
        for ($prefectureId = 1; $prefectureId <= 47; $prefectureId++)
        {
            $tradeRankingModel->importCityRanking($domainName, $prefectureId);
        }
    }

    protected function makeTownRanking(string $domainName, TradeRankingModel $tradeRankingModel)
    {
        for ($prefectureId = 1; $prefectureId <= 47; $prefectureId++)
        {
            $tradeRankingModel->importTownRanking($domainName, $prefectureId);
        }
    }

    protected function makeStationRanking(string $domainName, TradeRankingModel $tradeRankingModel)
    {
        for ($prefectureId = 1; $prefectureId <= 47; $prefectureId++)
        {
            $tradeRankingModel->importStationRanking($domainName, $prefectureId);
        }
    }

    protected function sendErrorMessage(string $message)
    {
//        $this->send(self::MAIL_TO, '[make:cpta] failed', '[make:cpta] cron ended in failure\n' . $message);
    }
}
