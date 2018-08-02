<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/12
 * Time: 19:19
 */

namespace App\Decorators;


use App\Condition\CityConditioner;
use App\Models\TradeRankingModel;
use App\Models\TradeRecordsModel;
use App\Value\AreaValue;

class CityTradeDecorator extends TradeDecorator
{
    public function __construct(AreaValue $areaValue)
    {
        parent::__construct($areaValue);

        $conditioner = CityConditioner::instance($this->areaValue);

        $tradeRankingModel = new TradeRankingModel();

        $cityId = $this->areaValue->cityId();
        $prefectureId = $this->areaValue->prefectureId();
        $this->figure = $tradeRankingModel->figure($conditioner, $prefectureId, $cityId);

        $this->setTotalPageNum();
    }

    public function tradeRecords(int $offset, int $limitCount)
    {
        $conditioner = CityConditioner::instance($this->areaValue);

        $tradeRecordModel = new TradeRecordsModel($conditioner);
        $results = $tradeRecordModel->retrieve($offset, $limitCount);

        return $results;
    }

    protected function tradeFigure(): array
    {
        $res['own'] = $this->figure;

        $conditioner = CityConditioner::instance($this->areaValue);

        $tradeRankingModel = new TradeRankingModel();

        $parentId = $this->areaValue->parentId();
        $res['parent'] = $tradeRankingModel->figure($conditioner, 0, $parentId);

        return $res;
    }

}
