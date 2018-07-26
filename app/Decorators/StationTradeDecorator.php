<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/12
 * Time: 19:20
 */

namespace App\Decorators;


use App\Condition\StationConditioner;
use App\Models\TradeRankingModel;
use App\Models\TradeRecordsModel;
use App\Value\AreaValue;

class StationTradeDecorator extends CityTradeDecorator
{
    public function __construct(AreaValue $areaValue)
    {
        parent::__construct($areaValue);

        $tradeRankingModel = new TradeRankingModel();

        $stationId = $this->areaValue->stationId();
        $this->figure = $tradeRankingModel->figure($stationId, 1);

        $this->setTotalPageNum();
    }

    public function tradeRecords(int $offset, int $limitCount)
    {
        $conditioner = new StationConditioner($this->areaValue);

        $tradeRecordModel = new TradeRecordsModel($conditioner);
        $results = $tradeRecordModel->retrieve($offset, $limitCount);

        return $results;
    }

    protected function tradeFigure(): array
    {
        $res['own'] = $this->figure;

        $tradeRankingModel = new TradeRankingModel();

        $parentId = $this->areaValue->parentId();
        $res['parent'] = $tradeRankingModel->figure($parentId);

        return $res;
    }

}
