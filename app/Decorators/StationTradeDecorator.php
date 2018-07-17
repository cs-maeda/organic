<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/12
 * Time: 19:20
 */

namespace App\Decorators;


use App\TradeRecordsModel;
use App\Value\AreaValue;

class StationTradeDecorator extends CityTradeDecorator
{
    public function __construct(AreaValue $areaValue)
    {
        parent::__construct($areaValue);
    }

    public function tradeRecords()
    {
        $stationId = $this->areaValue->stationId();

        $res = TradeRecordsModel::where('town_id', $stationId)
            ->offset($this->cursor)
            ->limit($this->limitCount)
            ->get();
        return $res;
    }

    protected function tradeRecordsCount(): int
    {
        $stationId = $this->areaValue->stationId();

        $res = TradeRecordsModel::where('city_id', $stationId)->count();
        return $res;
    }

}
