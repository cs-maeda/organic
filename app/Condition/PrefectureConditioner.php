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
    protected function __construct(AreaValue $areaValue, string $root = null)
    {
        parent::__construct($areaValue, $root);
    }

    static public function instance(AreaValue $areaValue, string $root = null): Conditioner
    {
        if (self::$instance == null){
            self::$instance = new PrefectureConditioner($areaValue, $root);
        }
        return self::$instance;
    }

    public function tradeTableCondition(array &$bindArray): string
    {
        $prefectureId = $this->areaValue->prefectureId();

        $condition = $this->appendCondition . ' AND tbl_trade_records.prefecture_id = ? ';
        $bindArray[] = $prefectureId;

        if ($this->siteNumber == 1){
            $condition .= 'AND type = ? ';
            $bindArray[] = self::TRADE_TYPE_LAND;
        }
        return $condition;
    }
}
