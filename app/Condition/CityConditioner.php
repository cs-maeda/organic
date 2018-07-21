<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/20
 * Time: 15:42
 */

namespace App\Condition;

use App\Value\AreaValue;

class CityConditioner extends Conditioner
{
    public function __construct(AreaValue $areaValue)
    {
        parent::__construct($areaValue);
    }

    public function tradeTableCondition(array &$bindArray): string
    {
        $cityId = $this->areaValue->cityId();

        $bindArray[] = $cityId;
        return $this->appendCondition . ' AND tbl_trade_records.city_id = ? ';
    }

}
