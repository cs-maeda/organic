<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/08/22
 * Time: 14:08
 */

namespace App\Factories;


use App\Condition\Conditioner;
use App\Models\PostedLandPriceAverageModel;
use App\Models\TradeRankingModel;
use App\Value\AreaValue;
use App\Value\DesignatedCityValue;

class PostedLandPriceRankingFactory
{
    const PREFECTURE_RANKING = 0;           // 都道府県ランキング
    const CITY_RANKING_IN_JAPAN = 1;        // 市区町村／日本ランキング
    const CITY_RANKING_IN_PREFECTURE = 2;   // 市区町村／都道府県ランキング
    const CITY_RANKING_OF_INCREASE = 3;     // 市区町村／都道府県ランキング（上昇率順）
    const POINT_RANKING_IN_CITY = 4;        // 標準値／市区町村ランキング

    protected $areaValue = null;

    public function __construct(AreaValue $areaValue)
    {
        $this->areaValue = $areaValue;
    }

    public function product(int $type): array
    {
        $res = [];
        switch ($type)
        {
            case self::PREFECTURE_RANKING:
                $res = $this->prefectureRanking();
                break;
            case self::CITY_RANKING_IN_JAPAN:
                $res = $this->cityRankingInJapan();
                break;
            case self::CITY_RANKING_IN_PREFECTURE:
                $res = $this->cityRankingInPrefecture();
                break;
            case self::CITY_RANKING_OF_INCREASE:
                $res = $this->cityRankingIncreaseOrder();
                break;
            case self::POINT_RANKING_IN_CITY:
                break;
        }
        return $res;
    }

    protected function prefectureRanking(): array
    {
        $model = new TradeRankingModel();

        $results = $model->prefectureRanking();

        $res = [];
        foreach ($results as $result)
        {
            $compared = 'up';
            if ($result['year_over_year'] == 0){
                $compared = 'flat';
            }
            if ($result['year_over_year'] < 0){
                $compared = 'down';
            }
            $res[] =
                [
                    'ranking' => $result['ranking'] . '位',
                    'area' => $result['prefecture_name'],
                    'link' => "/{$result['prefecture_alphabet']}/",
                    'average' => number_format($result['avg_price'] / 10000, 1) . '万円',
                    'yearOverYear' => number_format($result['year_over_year'], 2) . '％',
                    'compared' => $compared
                ];
        }
        return $res;
    }

    protected function cityRankingInJapan(): array
    {
        $value = new DesignatedCityValue();
        $model = new TradeRankingModel();

        $results = $model->cityRankingInJapan();

        $ranking = 1;
        $res = [];
        foreach ($results as $result)
        {
            $compared = 'up';
            if ($result['year_over_year'] == 0){
                $compared = 'flat';
            }
            if ($result['year_over_year'] < 0){
                $compared = 'down';
            }
            $designatedCity = $value->isDesignatedCity($result['city_id']);
            $areaName = $result['prefecture_name'] . $result['city_name'];
            if ($designatedCity === true){
                $areaName = $result['city_name'];
            }
            $res[] =
                [
                    'ranking' => $ranking . '位',
                    'area' => $areaName,
                    'link' => "/{$result['prefecture_alphabet']}/{$result['city_alphabet']}/",
                    'average' => number_format($result['avg_price'] / 10000, 1) . '万円',
                    'yearOverYear' => number_format($result['year_over_year'], 2) . '％',
                    'compared' => $compared
                ];
            $ranking++;
        }
        return $res;
    }

    protected function cityRankingInPrefecture(): array
    {
        $model = new TradeRankingModel();

        $prefectureId = $this->areaValue->prefectureId();
        $results = $model->cityRankingInPrefecture($prefectureId);

        $res = [];
        foreach ($results as $result)
        {
            $compared = 'up';
            if ($result['year_over_year'] == 0){
                $compared = 'flat';
            }
            if ($result['year_over_year'] < 0){
                $compared = 'down';
            }
            $res[] =
                [
                    'ranking' => $result['ranking'] . '位',
                    'area' => $result['city_name'],
                    'link' => "/{$result['prefecture_alphabet']}/{$result['city_alphabet']}/",
                    'average' => number_format($result['avg_price'] / 10000, 1) . '万円',
                    'yearOverYear' => number_format($result['year_over_year'], 2) . '％',
                    'compared' => $compared
                ];
        }
        return $res;
    }

    protected function cityRankingIncreaseOrder()
    {
        $model = new TradeRankingModel();

        $prefectureId = $this->areaValue->prefectureId();
        $results = $model->cityRankingIncreaseOrder($prefectureId);

        $res = [];
        $ranking = 1;
        foreach ($results as $result)
        {
            $compared = 'up';
            if ($result['year_over_year'] == 0){
                $compared = 'flat';
            }
            if ($result['year_over_year'] < 0){
                $compared = 'down';
            }
            $res[] =
                [
                    'ranking' => $ranking . '位',
                    'area' => $result['city_name'],
                    'link' => "/{$result['prefecture_alphabet']}/{$result['city_alphabet']}/",
                    'average' => number_format($result['avg_price'] / 10000, 1) . '万円',
                    'yearOverYear' => number_format($result['year_over_year'], 2) . '％',
                    'compared' => $compared
                ];
            $ranking++;
        }
        return $res;
    }

}
