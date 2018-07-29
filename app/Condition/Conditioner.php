<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/20
 * Time: 15:33
 */

namespace App\Condition;

use App\Value\AreaValue;
use Illuminate\Support\Facades\Request;

abstract class Conditioner
{
    static protected $instance = null;

    protected $areaValue = null;
    protected $siteNumber = null;
    protected $appendCondition = '';

    protected function __construct(AreaValue $areaValue, string $root = null)
    {
        $this->areaValue = $areaValue;

        if ($root === null){
            $root = Request::root();
        }
        $res = strpos($root, 'iacs-icc');   // www.iacs-icc.org
        if ($res !== false){
            $this->siteNumber = 0;
        }
        $res = strpos($root, 'rhs-inc');    // www.rhs-inc.com
        if ($res !== false){
            $this->siteNumber = 1;
        }
    }

    public function setAppendCondition($condition)
    {
        $this->appendCondition = $condition;
    }

    public function siteCondition(array &$bindArray): string
    {
        $bindArray[] = $this->siteNumber;
        return " AND site_number = ? ";
    }

    abstract public function tradeTableCondition(array &$bindArray): string;
}
