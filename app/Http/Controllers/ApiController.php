<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/12
 * Time: 16:00
 */

namespace App\Http\Controllers;

use App\Condition\Conditioner;
use App\Factories\AreaFactory;
use App\Factories\AreaFactoryEx;
use App\Factories\CityAreaFactory;
use App\Factories\ConditionerFactory;
use App\Factories\EachLinkFactory;
use App\Factories\PrefectureAreaFactory;
use App\Factories\StationAreaFactory;
use App\Factories\TownAreaFactory;
use App\Factories\TradeDecoratorFactory;
use App\Models\CityModel;
use App\Models\PostedLandPriceAverageModel;
use App\Models\PostedLandPriceModel;
use App\Models\TownModel;
use App\Models\TradeRankingModel;
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
        foreach ($results as $result) {
            $res[$result['city_id']] = $result['city_name'];
        }
        return response()->json($res);
    }

    public function townList(int $cityId)
    {
        $results = TownModel::where('city_id', $cityId)->orderBy('mst_town_id')->get();

        $res = [];
        foreach ($results as $result) {
            if ($result['town_name'] == '') {
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

    public function linkExists(string $prefecture = null, string $city = null, int $townId = null)
    {
        $link = [];

        $areaFactory = new AreaFactory($prefecture, $city, $townId);
        $areaValue = $areaFactory->product();
        if ($prefecture !== null){
            $res = $areaValue->validArea();
            if ($res === false){
                $link['exist'] = false;
                return json_encode($link);
            }
        }

        $factory = new ConditionerFactory($areaValue);
        $conditioner = $factory->product();
        $siteNumber = $conditioner->siteNumber();

        $eachLinkFactory = new EachLinkFactory($areaValue);
        $res = $eachLinkFactory->existLink($conditioner, $siteNumber, $link);
        $link['exist'] = $res;

        return json_encode($link);
    }

    public function stationLinkExists(string $prefecture = null, string $city = null, int $stationId = null)
    {
        $areaFactory = new AreaFactory($prefecture, $city, $stationId, true);
        $areaValue = $areaFactory->product();
        if ($prefecture !== null){
            $res = $areaValue->validArea();
            if ($res === false){
                $link['exist'] = false;
                return json_encode($link);
            }
        }

        $factory = new ConditionerFactory($areaValue);
        $conditioner = $factory->product();
        $siteNumber = $conditioner->siteNumber();

        $eachLinkFactory = new EachLinkFactory($areaValue);
        $link = [];
        $res = $eachLinkFactory->existLink($conditioner, $siteNumber, $link);
        $link['exist'] = $res;

        return json_encode($link);
    }

    public function ginatonicAverage(int $areaId = 0)
    {
        $res["japan"] = $this->averageImpl(0);
        if ($areaId > 0){
            $res["area"] = $this->averageImpl($areaId);
        }
        return json_encode($res);
    }

    public function ginatonicPrefectureDetail(string $prefecture)
    {
        $factory = new AreaFactory($prefecture);
        $areaValue = $factory->product();
        $areaCaption = $areaValue->displayName();
        $prefectureId = $areaValue->prefectureId();

        $sentence = [];
        $result = TradeRankingModel::where('site_number', Conditioner::SITE_NUMBER_GINATONIC)
                            ->where('area_id', $prefectureId)->first();

        $ratio = number_format($result['year_over_year'], 1);
        $upDown = '下落';
        if ($ratio >= 0){
            $upDown = '上昇';
        }
        $sentence = "{$areaCaption}の地価公示価格の平均価格は、47都道府県中<span class='impactValue'>{$result['ranking']}位</span>、前年比は<span class='impactValue'>{$ratio}％</span>の{$upDown}。<br/>";

        $results = TradeRankingModel::leftjoin('mst_city', 'area_id', '=', 'mst_city.city_id')
                            ->where('site_number', Conditioner::SITE_NUMBER_GINATONIC)
                            ->where('tbl_trade_ranking.prefecture_id', $prefectureId)
                            ->orderBy('avg_price', 'desc')->get();

        $unitPrice = number_format($results[0]['avg_price'] / 10000, 1);
        $sentence .= "{$areaCaption}内で最も地価公示価格の平均が高い地域は{$results[0]['city_name']}で、1平方メートルあたり単価の平均は<span class='impactValue'>{$unitPrice}万円</span><br/>";

        $result = $results[count($results) - 1];
        $unitPrice = number_format($result['avg_price'] / 10000, 1);

        $sentence .= "また、最も地価公示価格の平均が低い地域は{$result['city_name']}、1平方メートルあたり単価の平均は<span class='impactValue'>{$unitPrice}万円</span>です。<br/>";

        $results = TradeRankingModel::leftjoin('mst_city', 'area_id', '=', 'mst_city.city_id')
                            ->where('site_number', Conditioner::SITE_NUMBER_GINATONIC)
                            ->where('tbl_trade_ranking.prefecture_id', $prefectureId)
                            ->orderBy('year_over_year', 'desc')->get();

        $ratio = number_format($results[0]['year_over_year'], 1);
        if ($ratio >= 0){
            $ratio = '+' . $ratio;
        }
        $sentence .= "変動率で見ると、最も上昇率が高かったのは{$results[0]['city_name']}で前年比<span class='impactValue'>{$ratio}％</span>";

        $result = $results[count($results) - 1];
        $ratio = number_format($result['year_over_year'], 1);
        if ($ratio >= 0){
            $ratio = '+' . $ratio;
        }
        $sentence .= "最も上昇率が低かったのは{$result['city_name']}で前年比<span class='impactValue'>{$ratio}％</span>でした。";

        return json_encode($sentence);
    }

    protected function ginatonicCityDetail(Request $request, string $prefecture, string $city)
    {
        $factory = new AreaFactory($prefecture, $city);
        $areaValue = $factory->product();
        $areaCaption = $areaValue->displayName();
        $prefectureName = $areaValue->prefectureName();
        $prefectureId = $areaValue->prefectureId();
        $cityId = $areaValue->cityId();

        $result = TradeRankingModel::leftjoin('mst_city', 'area_id', '=', 'mst_city.city_id')
            ->where('site_number', Conditioner::SITE_NUMBER_GINATONIC)
            ->where('tbl_trade_ranking.prefecture_id', $prefectureId)
            ->where('tbl_trade_ranking.area_id', $cityId)
            ->first();

        $ranking = $result['ranking'];
        $ratio = number_format($result['year_over_year'], 1);
        $upDown = '下落';
        if ($ratio >= 0){
            $upDown = '上昇';
        }
        $sentence = "{$areaCaption}の地価公示価格の平均値は、{$prefectureName}内で<span class='impactValue'>{$ranking}</span>位で、";
        $sentence .= "前年比は<span class='impactValue'>{$ratio}</span>％の{$upDown}でした。<br/>";

        $result = TradeRankingModel::leftjoin('mst_city', 'area_id', '=', 'mst_city.city_id')
            ->where('site_number', Conditioner::SITE_NUMBER_GINATONIC)
            ->where('tbl_trade_ranking.prefecture_id', 0)
            ->where('tbl_trade_ranking.area_id', $cityId)
            ->first();

        $sentence .= "また、日本全国の市区町村別で見ると{$areaCaption}は{$result['ranking']}位で、さらに詳細に見ると、";

        $results = PostedLandPriceModel::leftjoin('mst_city', 'tbl_posted_land_price.city_id', '=', 'mst_city.city_id')
            ->where('tbl_posted_land_price.city_id', $cityId)
            ->where('year', 2018)
            ->orderBy('price', 'desc')->get();

        $unitPrice = number_format($results[0]['price'] / 10000, 1);
        $sentence .= "{$areaCaption}の標準地で最も高かったのは<span class='noWrap'>{$results[0]['address']}</span>で、１平方メートルあたりの単価は<span class='impactValue'>{$unitPrice}</span>万円、";

        $result = $results[count($results) - 1];
        $unitPrice = number_format($result['price'] / 10000, 1);
        $sentence .= "最も低かったのは<span class='noWrap'>{$result['address']}</span>で、１平方メートルあたりの単価は<span class='impactValue'>{$unitPrice}</span>万円です。";

        return json_encode($sentence);




    }

    protected function averageImpl(int $areaId)
    {
        $model = new PostedLandPriceAverageModel();
        $results = $model->average($areaId);

        $res = [];
        foreach ($results as $result)
        {
            $res[$result['year']] = "{$result['average']}";
        }
        return $res;
    }

    protected function tradeRecords($areaValue, $pageNum, $action)
    {
        $tradeDecoratorFactory = new TradeDecoratorFactory($areaValue);
        $tradeDecorator = $tradeDecoratorFactory->product();

        $res = [];
        $tradeDecorator->setPageNum($pageNum);
        switch ($action){
            case 'first':
                $res = $tradeDecorator->first();
                break;
            case 'last':
                $res = $tradeDecorator->last();
                break;
            case 'next':
                $res = $tradeDecorator->next();
                break;
            case 'prev':
                $res = $tradeDecorator->previous();
                break;
            default:
                $res = [];
                break;
        }
        return response()->json($res);
    }

}
