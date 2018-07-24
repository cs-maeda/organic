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

        $this->setTotalPageNum();
    }

    public function setPageNum(int $pageNum)
    {
        $this->pageNum = $pageNum;
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
        if ($this->pageNum + 1 > $this->totalPageNum){
            throw new OrganicException();
        }
        $this->pageNum++;
        $results = $this->retrieve($this->pageNum, $this->totalPageNum, $this->limitCount);

        return $results;
    }

    public function previous(): array
    {
        if ($this->pageNum <= 1){
            throw new OrganicException();
        }
        $this->pageNum--;
        $results = $this->retrieve($this->pageNum, $this->totalPageNum, $this->limitCount);

        return $results;
    }

    public function first(): array
    {
        $this->pageNum = 1;
        $results = $this->retrieve($this->pageNum, $this->totalPageNum, $this->limitCount);

        return $results;
    }

    public function last(): array
    {
        $this->pageNum = $this->totalPageNum;
        $results = $this->retrieve($this->pageNum, $this->totalPageNum, $this->limitCount);

        return $results;
    }

    public function figure(): array
    {
        $results = $this->tradeFigure();
        return $results;
    }

    protected function setTotalPageNum()
    {
        $this->recordsCount = $this->figure['trade_count'];
        $this->totalPageNum = intval(($this->figure['trade_count'] + ($this->limitCount - 1)) / $this->limitCount);
    }

    protected function retrieve(int $pageNum, int $totalPageNum, int $limitCount): array
    {
        $offset = (($pageNum - 1) * $limitCount) + 1;
        $results['tradeRecord'] = $this->tradeRecords($offset, $limitCount);

        $results['tradeTable']['pageNum'] = $pageNum;
        $results['tradeTable']['recordsCount'] = $this->recordsCount;

        $results['pager']['buttonFirst'] = true;
        $results['pager']['buttonPrev'] = true;
        $results['pager']['buttonNext'] = true;
        $results['pager']['buttonLast'] = true;

        $startPageNum = $pageNum - 2;
        if (($totalPageNum <= 5)||($pageNum <= 3)){
            $startPageNum = 1;
        }
        if (($totalPageNum > 5)&&(($pageNum + 3) > $totalPageNum)){
            $startPageNum = $totalPageNum - 4;
        }

        for ($index = $startPageNum, $count = 0; ($index <= $totalPageNum) && ($count < 5); $index++, $count++){
            $results['pager']['buttonNumber'][] = $index;
        }

        if ($startPageNum <= 1){
            $results['pager']['buttonFirst'] = false;
        }
        if ($pageNum <= 1){
            $results['pager']['buttonPrev'] = false;
        }
        if ($startPageNum >= ($totalPageNum - 5)){
            $results['pager']['buttonLast'] = false;
        }
        if ($pageNum >= $totalPageNum){
            $results['pager']['buttonNext'] = false;
        }
        return $results;
    }

    abstract protected function tradeRecords(int $pageNum, int $limitCount);
    abstract protected function tradeFigure(): array;
}
