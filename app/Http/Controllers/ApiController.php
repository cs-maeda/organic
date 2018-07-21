<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/12
 * Time: 16:00
 */

namespace App\Http\Controllers;

use App\Factories\AreaFactory;
use App\Factories\AreaFactoryEx;
use App\Factories\CityAreaFactory;
use App\Factories\PrefectureAreaFactory;
use App\Factories\StationAreaFactory;
use App\Factories\TownAreaFactory;
use App\Factories\TradeDecoratorFactory;
use App\Models\CityModel;
use App\Models\TownModel;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected $conn;

    public function __construct(ConnectionInterface $conn)
    {
        $this->conn = $conn;
    }

    public function unitTest(int $id)
    {
        $factory = new StationAreaFactory(500);
    }

    public function cityList(int $prefectureId)
    {
        $results = CityModel::where('prefecture_id', $prefectureId)->orderBy('city_id')->get();

        $res = [];
        foreach ($results as $result){
            $res[$result['city_id']] = $result['city_name'];
        }
        return response()->json($res);
    }

    public function townList(int $cityId)
    {
        $results = TownModel::where('city_id', $cityId)->orderBy('mst_town_id')->get();

        $res = [];
        foreach ($results as $result){
            if ($result['town_name'] == ''){
                continue;
            }
            $res[$result['mst_town_id']] = $result['town_name'];
        }
        return json_encode($res);
    }

    public function prefectureTradeRecords(int $prefectureId, int $pageNum, string $action)
    {
        $areaFactory = new PrefectureAreaFactory($prefectureId);
        $areaValue = $areaFactory->product();

        return $this->tradeRecords($areaValue, $pageNum, $action);
    }

    public function cityTradeRecords(int $cityId, int $pageNum, string $action)
    {
        $areaFactory = new CityAreaFactory($cityId);
        $areaValue = $areaFactory->product();

        return $this->tradeRecords($areaValue, $pageNum, $action);
    }

    public function townTradeRecords(int $townId, int $pageNum, string $action)
    {
        $areaFactory = new TownAreaFactory($townId);
        $areaValue = $areaFactory->product();

        return $this->tradeRecords($areaValue, $pageNum, $action);
    }

    public function stationTradeRecords(int $stationId, int $pageNum, string $action)
    {
        $areaFactory = new StationAreaFactory($stationId);
        $areaValue = $areaFactory->product();

        return $this->tradeRecords($areaValue, $pageNum, $action);
    }

    protected function tradeRecords($areaValue, $pageNum, $action)
    {
        $tradeDecoratorFactory = new TradeDecoratorFactory($areaValue);
        $tradeDecorator = $tradeDecoratorFactory->product();

        $res = [];
        $tradeDecorator->setPageNum($pageNum);
        switch ($action){
            case 'first':
                $res['tradeRecord'] = $tradeDecorator->first();
                break;
            case 'last':
                $res['tradeRecord'] = $tradeDecorator->last();
                break;
            case 'next':
                $res['tradeRecord'] = $tradeDecorator->next();
                break;
            case 'prev':
                $res['tradeRecord'] = $tradeDecorator->previous();
                break;
        }
        $res['tradeTable']['cursor'] = $tradeDecorator->cursor();
        $res['tradeTable']['recordsCount'] = $tradeDecorator->recordsCount();

        return response()->json($res);
    }

}
