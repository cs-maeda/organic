<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/20
 * Time: 15:35
 */

namespace App\Condition;

use App\Value\AreaValue;

class PrefectureConditioner extends Conditioner
{
    public function __construct(AreaValue $areaValue)
    {
        parent::__construct($areaValue);
    }

    public function tradeTableCondition(array &$bindArray): string
    {
        $prefectureId = $this->areaValue->prefectureId();

        $bindArray[] = $prefectureId;
        return $this->appendCondition . ' AND tbl_trade_records.prefecture_id = ? ';
    }
}
