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

    const TRADE_ESTATE_SITE = 0;
    const TRADE_LAND_SITE = 1;

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
        $tradeRankingModel->clearTable(self::TRADE_ESTATE_SITE);
        $tradeRankingModel->clearTable(self::TRADE_LAND_SITE);

        echo '------ www.iacs-icc.org ------------------' . PHP_EOL;
        $this->makeRankingImpl('iacs-icc.org', $tradeRankingModel);
        echo '------ www.rhs-inc.com ------------------' . PHP_EOL;
        $this->makeRankingImpl('rhs-inc.com', $tradeRankingModel);
    }

    protected function makeRankingImpl(string $domainName, TradeRankingModel $tradeRankingModel)
    {
        echo '   average of within the country' . PHP_EOL;
        $this->makeJapanAverage($domainName, $tradeRankingModel);
        echo '   prefecture ranking' . PHP_EOL;
        $this->makePrefectureRanking($domainName, $tradeRankingModel);
        echo '   city ranking' . PHP_EOL;
        $this->makeCityRanking($domainName, $tradeRankingModel);
        echo '   town ranking' . PHP_EOL;
        $this->makeTownRanking($domainName, $tradeRankingModel);
        echo '   station ranking' . PHP_EOL;
        $this->makeStationRanking($domainName, $tradeRankingModel);
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
            echo "     {$prefectureId}" . PHP_EOL;
            $tradeRankingModel->importCityRanking($domainName, $prefectureId);
        }
    }

    protected function makeTownRanking(string $domainName, TradeRankingModel $tradeRankingModel)
    {
        for ($prefectureId = 1; $prefectureId <= 47; $prefectureId++)
        {
            echo "     {$prefectureId}" . PHP_EOL;
            $tradeRankingModel->importTownRanking($domainName, $prefectureId);
        }
    }

    protected function makeStationRanking(string $domainName, TradeRankingModel $tradeRankingModel)
    {
        for ($prefectureId = 1; $prefectureId <= 47; $prefectureId++)
        {
            echo "     {$prefectureId}" . PHP_EOL;
            $tradeRankingModel->importStationRanking($domainName, $prefectureId);
        }
    }

    protected function sendErrorMessage(string $message)
    {
//        $this->send(self::MAIL_TO, '[make:cpta] failed', '[make:cpta] cron ended in failure\n' . $message);
    }
}
