<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/20
 * Time: 15:45
 */

namespace App\Condition;


use App\Value\AreaValue;

class TownConditioner extends Conditioner
{
    public function __construct(AreaValue $areaValue)
    {
        parent::__construct($areaValue);
    }

    public function tradeTableCondition(array &$bindArray): string
    {
        $townId = $this->areaValue->townId();

        $bindArray[] = $townId;
        return $this->appendCondition . ' AND tbl_trade_records.town_id = ? ';
    }

}
