<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/12
 * Time: 19:17
 */

namespace App\Decorators;


use App\Exceptions\OrganicException;
use App\Value\AreaValue;
use Mockery\Exception;

abstract class TradeDecorator
{
    protected $pageNum = 1;
    protected $totalPageNum = 0;
    protected $recordsCount = 0;
    protected $limitCount = 30;
    protected $areaValue = null;
    protected $figure = null;

    public function __construct(AreaValue $areaValue)
    {
        $this->pageNum = 1;
        $this->areaValue = $areaValue;
    }

    public function setLimitCount(int $count)
    {
        $this->limitCount = $count;
    }

    public function setPageNum(int $pageNum)
    {
        $this->cursor = $pageNum;
    }

    public function pageNum()
    {
        return $this->pageNum;
    }

    public function recordsCount()
    {
        return $this->recordsCount;
    }

    public function next(): array
    {
        if ((($this->pageNum * $this->limitCount) + 1) > $this->figure['trade_count']){
            throw new OrganicException();
        }
        $offset = $this->pageNum * $this->limitCount + 1;
        $this->pageNum++;
        $results = $this->tradeRecords($offset, $this->limitCount);
        $this->recordsCount = count($results);

        return $results;
    }

    public function previous(): array
    {
        if (($this->cursor - $this->limitCount) < 1){
            throw new OrganicException();
        }
        $this->cursor -= $this->limitCount;
        $results = $this->tradeRecords($this->cursor, $this->limitCount);
        $this->recordsCount = count($results);

        return $results;
    }

    public function first(): array
    {
        $this->cursor = 1;
        $results = $this->tradeRecords($this->cursor, $this->limitCount);
        $this->recordsCount = count($results);

        return $results;
    }

    public function last(): array
    {
        $this->cursor = 1;
        for ($index = 1; $index <= $this->figure['trade_count']; $index += $this->limitCount){
            $this->cursor += $this->limitCount;
        }
        $results = $this->tradeRecords($this->cursor, $this->limitCount);
        $this->recordsCount = count($results);

        return $results;
    }

    public function figure(): array
    {
        $results = $this->tradeFigure();
        return $results;
    }

    protected function setTotalPageNum()
    {
        $this->totalPageNum = intval(($this->figure['trade_count'] + ($this->limitCount - 1)) / $this->limitCount);
    }

    abstract protected function tradeRecords(int $cursor, int $limitCount);
    abstract protected function tradeFigure(): array;
}
