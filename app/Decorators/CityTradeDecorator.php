<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/12
 * Time: 19:19
 */

namespace App\Decorators;


use App\TradeRecordsModel;
use App\Value\AreaValue;

class CityTradeDecorator extends PrefectureTradeDecorator
{
    public function __construct(AreaValue $areaValue)
    {
        parent::__construct($areaValue);
    }

    public function tradeRecords()
    {
        $cityId = $this->areaValue->cityId();

        $res = TradeRecordsModel::where('prefecture_id', $cityId)
            ->offset($this->cursor)
            ->limit($this->limitCount)
            ->get();
        return $res;
    }

    protected function tradeRecordsCount(): int
    {
        $cityId = $this->areaValue->cityId();

        $res = TradeRecordsModel::where('city_id', $cityId)->count();
        return $res;
    }


}
