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

        echo '------ www.ginatonic.net ------------------' . PHP_EOL;
        $this->makeRankingImpl($model);
    }

    protected function makeRankingImpl(TradeRankingModel $tradeRankingModel)
    {
        echo '   prefecture ranking' . PHP_EOL;
        $this->makePrefectureRanking($tradeRankingModel);

        echo '   city ranking' . PHP_EOL;
        $this->makeCityRanking($tradeRankingModel);

        echo '   city ranking in Japan' . PHP_EOL;
        $this->makeCityRankingInJapan($tradeRankingModel);

        echo '   create tbl_trade_ranking_last' . PHP_EOL;
        $tradeRankingModel->createPostedLandPriceLast();

        echo '   prefecture ranking last' . PHP_EOL;
        $this->makePrefectureRankingLast($tradeRankingModel);

        echo '   city ranking last' . PHP_EOL;
        $this->makeCityRankingLast($tradeRankingModel);

        echo '   city ranking in Japan' . PHP_EOL;
        $this->makeCityRankingInJapanLast($tradeRankingModel);

        echo '   import year-over-year' . PHP_EOL;
        $this->makeYearOverYear($tradeRankingModel);

    }

    protected function makeYearOverYear(TradeRankingModel $tradeRankingModel)
    {
        $tradeRankingModel->makeYearOverYear();
    }

    protected function makePrefectureRanking(TradeRankingModel $tradeRankingModel)
    {
        $tradeRankingModel->importPostedPricePrefectureRanking();
    }

    protected function makeCityRanking(TradeRankingModel $tradeRankingModel)
    {
        for ($prefectureId = 1; $prefectureId <= 47; $prefectureId++)
        {
            echo "     {$prefectureId}" . PHP_EOL;
            $tradeRankingModel->importPostedPriceCityRanking($prefectureId);
        }
    }

    protected function makeCityRankingInJapan(TradeRankingModel $tradeRankingModel)
    {
        $tradeRankingModel->importPostedPriceCityRankingInJapan();
    }

    protected function makePrefectureRankingLast(TradeRankingModel $tradeRankingModel)
    {
        $tradeRankingModel->importPostedPricePrefectureRankingLast();
    }

    protected function makeCityRankingLast(TradeRankingModel $tradeRankingModel)
    {
        for ($prefectureId = 1; $prefectureId <= 47; $prefectureId++)
        {
            echo "     {$prefectureId}" . PHP_EOL;
            $tradeRankingModel->importPostedPriceCityRankingLast($prefectureId);
        }
    }

    protected function makeCityRankingInJapanLast(TradeRankingModel $tradeRankingModel)
    {
        $tradeRankingModel->importPostedPriceCityRankingInJapanLast();
    }

    protected function sendErrorMessage(string $message)
    {
//        $this->send(self::MAIL_TO, '[make:cpta] failed', '[make:cpta] cron ended in failure\n' . $message);
    }
}
