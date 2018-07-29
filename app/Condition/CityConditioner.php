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
    protected function __construct(AreaValue $areaValue, string $root = null)
    {
        parent::__construct($areaValue, $root);
    }

    static public function instance(AreaValue $areaValue, string $root = null): Conditioner
    {
        if (self::$instance == null){
            self::$instance = new CityConditioner($areaValue, $root);
        }
        return self::$instance;
    }

    public function tradeTableCondition(array &$bindArray): string
    {
        $cityId = $this->areaValue->cityId();

        $bindArray[] = $cityId;
        return $this->appendCondition . ' AND tbl_trade_records.city_id = ? ';
    }

}
