<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/12
 * Time: 19:17
 */

namespace App\Decorators;


use App\Value\AreaValue;

abstract class TradeDecorator
{
    protected $cursor = 0;
    protected $limitCount = 30;
    protected $areaValue = null;
    protected $tradeCount = 0;

    public function __construct(AreaValue $areaValue)
    {
        $this->cursor = 0;
        $this->areaValue = $areaValue;

        $this->tradeCount = $this->tradeRecordsCount();
    }

    public function setLimitCount(int $count)
    {
        $this->limitCount = $count;
    }

    public function next(): array
    {

    }

    public function previous(): array
    {

    }

    public function first(): array
    {

    }

    public function last(): array
    {

    }

    public function count(): int
    {
        return $this->tradeCount;
    }

    public function figure(): array
    {
        $res['count'] = $this->tradeCount;

        $results = $this->tradeFigure();
        $res['min_price'] = $results['min_price'];
        $res['max_price'] = $results['max_price'];
        $res['avg_price'] = $results['avg_price'];

        return $res;
    }

    abstract protected function tradeRecordsCount(): int;
    abstract protected function tradeRecords();
    abstract protected function tradeFigure(): array;
}
