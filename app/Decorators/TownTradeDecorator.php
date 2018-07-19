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

class TownTradeDecorator extends CityTradeDecorator
{
    public function __construct(AreaValue $areaValue)
    {
        parent::__construct($areaValue);
    }

    public function tradeRecords()
    {
        $townId = $this->areaValue->townId();

        $res = TradeRecordsModel::where('town_id', $townId)
            ->offset($this->cursor)
            ->limit($this->limitCount)
            ->get();
        return $res;
    }

    protected function tradeRecordsCount(): int
    {
        $townId = $this->areaValue->townId();

        $res = TradeRecordsModel::where('city_id', $townId)->count();
        return $res;
    }

    protected function tradeFigure(): array
    {
        $townId = $this->areaValue->townId();

        $tradeRecordsModel = new TradeRecordsModel();
        $res = $tradeRecordsModel->averageTown($townId);
        return $res;
    }

}
