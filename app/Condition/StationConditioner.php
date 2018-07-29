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
    protected function __construct(AreaValue $areaValue, string $root = null)
    {
        parent::__construct($areaValue, $root);
    }

    static public function instance(AreaValue $areaValue, string $root = null): Conditioner
    {
        if (self::$instance == null){
            self::$instance = new StationConditioner($areaValue, $root);
        }
        return self::$instance;
    }

    public function tradeTableCondition(array &$bindArray): string
    {
        $stationId = $this->areaValue->stationId();

        $bindArray[] = $stationId;
        return $this->appendCondition . ' AND tbl_trade_records.station_id = ? ';
    }

}
