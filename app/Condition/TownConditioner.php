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
    protected function __construct(AreaValue $areaValue, string $root = null)
    {
        parent::__construct($areaValue, $root);
    }

    static public function instance(AreaValue $areaValue, string $root = null): Conditioner
    {
        if (self::$instance == null){
            self::$instance = new TownConditioner($areaValue, $root);
        }
        return self::$instance;
    }

    public function tradeTableCondition(array &$bindArray): string
    {
        $townId = $this->areaValue->townId();

        $bindArray[] = $townId;
        return $this->appendCondition . ' AND tbl_trade_records.town_id = ? ';
    }

    public function siteNumberCondition(array &$bindArray): string
    {

    }

}
