<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/20
 * Time: 15:33
 */

namespace App\Condition;

use App\Value\AreaValue;

abstract class Conditioner
{
    protected $areaValue = null;
    protected $appendCondition = '';

    public function __construct(AreaValue $areaValue)
    {
        $this->areaValue = $areaValue;
    }

    public function setAppendCondition($condition)
    {
        $this->appendCondition = $condition;
    }

    abstract public function tradeTableCondition(array &$bindArray): string;
}
