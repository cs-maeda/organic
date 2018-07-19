<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/12
 * Time: 19:18
 */

namespace App\Decorators;


use App\TradeRecordsModel;
use App\Value\AreaValue;

class PrefectureTradeDecorator extends TradeDecorator
{
    public function __construct(AreaValue $areaValue)
    {
        parent::__construct($areaValue);
    }

    public function tradeRecords()
    {
        $prefectureId = $this->areaValue->prefectureId();

        $res = TradeRecordsModel::where('mst_prefecture_id', $prefectureId)
            ->join('mst_prefecture', 'tbl_trade_records.prefecture_id', '=', 'mst_prefecture.mst_prefecture_id')
            ->paginate($this->limitCount);
        return $res;
    }

    protected function tradeRecordsCount(): int
    {
        $prefectureId = $this->areaValue->prefectureId();

        $res = TradeRecordsModel::where('prefecture_id', $prefectureId)->count();
        return $res;
    }

    protected function tradeFigure(): array
    {
        $prefectureId = $this->areaValue->prefectureId();

        $tradeRecordsModel = new TradeRecordsModel();
        $res = $tradeRecordsModel->averagePrefecture($prefectureId);
        return $res;
    }

}
