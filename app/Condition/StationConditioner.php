<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/21
 * Time: 15:45
 */

namespace App\Condition;


use App\Value\AreaValue;

class StationConditioner extends Conditioner
{
    public function __construct(AreaValue $areaValue)
    {
        parent::__construct($areaValue);
    }

    public function tradeTableCondition(array &$bindArray): string
    {
        $stationId = $this->areaValue->stationId();

        $bindArray[] = $stationId;
        return $this->appendCondition . ' AND tbl_trade_records.station_id = ? ';
    }

}
