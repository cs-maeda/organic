<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/20
 * Time: 18:21
 */

namespace App\Factories;


use App\Decorators\CityTradeDecorator;
use App\Decorators\PrefectureTradeDecorator;
use App\Decorators\StationTradeDecorator;
use App\Decorators\TownTradeDecorator;
use App\Decorators\TradeDecorator;
use App\Value\AreaValue;

class TradeDecoratorFactory
{
    protected $areaValue = null;

    public function __construct(AreaValue $areaValue)
    {
        $this->areaValue = $areaValue;
    }

    public function product(): TradeDecorator
    {
        $tradeDecorator = null;

        $where = $this->areaValue->where();
        switch ($where){
            case 'prefecture':
                $tradeDecorator = new PrefectureTradeDecorator($this->areaValue);
                break;
            case 'city':
                $tradeDecorator = new CityTradeDecorator($this->areaValue);
                break;
            case 'town':
                $tradeDecorator = new TownTradeDecorator($this->areaValue);
                break;
            case 'station':
                $tradeDecorator = new StationTradeDecorator($this->areaValue);
                break;
            default:
                break;
        }
        return $tradeDecorator;
    }
}
