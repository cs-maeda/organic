<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/12
 * Time: 19:19
 */

namespace App\Decorators;


use App\Condition\TownConditioner;
use App\Models\TradeRankingModel;
use App\Models\TradeRecordsModel;
use App\Value\AreaValue;

class TownTradeDecorator extends CityTradeDecorator
{
    public function __construct(AreaValue $areaValue)
    {
        parent::__construct($areaValue);

        $tradeRankingModel = new TradeRankingModel();

        $townId = $this->areaValue->townId();
        $this->figure = $tradeRankingModel->figure($townId);

        $this->setTotalPageNum();
    }

    public function tradeRecords(int $pageNum, int $limitCount)
    {
        $conditioner = new TownConditioner($this->areaValue);

        $tradeRecordModel = new TradeRecordsModel($conditioner);
        $results = $tradeRecordModel->retrieve($pageNum, $limitCount);

        return $results;
    }

    protected function tradeFigure(): array
    {
        $res['own'] = $this->figure;

        $tradeRankingModel = new TradeRankingModel();

        $parentId = $this->areaValue->parentId();
        $res['parent'] = $tradeRankingModel->figure($parentId);

        return $res;
    }

}
