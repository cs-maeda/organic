<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/12
 * Time: 19:18
 */

namespace App\Decorators;


use App\Condition\PrefectureConditioner;
use App\Models\TradeRankingModel;
use App\Models\TradeRecordsModel;
use App\Value\AreaValue;

class PrefectureTradeDecorator extends TradeDecorator
{
    public function __construct(AreaValue $areaValue)
    {
        parent::__construct($areaValue);

        $conditioner = PrefectureConditioner::instance($this->areaValue);

        $tradeRankingModel = new TradeRankingModel();

        $prefectureId = $this->areaValue->prefectureId();
        $this->figure = $tradeRankingModel->figure($conditioner, 0, $prefectureId);

        $this->setTotalPageNum();
    }

    public function tradeRecords(int $offset, int $limitCount)
    {
        $conditioner = PrefectureConditioner::instance($this->areaValue);

        $tradeRecordModel = new TradeRecordsModel($conditioner);
        $results = $tradeRecordModel->retrieve($offset, $limitCount);

        return $results;
    }

    protected function tradeFigure(): array
    {
        $res['own'] = $this->figure;

        $conditioner = PrefectureConditioner::instance($this->areaValue);

        $tradeRankingModel = new TradeRankingModel();

        $parentId = $this->areaValue->parentId();
        $res['parent'] = $tradeRankingModel->figure($conditioner, 0, $parentId);

        return $res;
    }

}
