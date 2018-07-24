<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/11
 * Time: 17:44
 */

namespace App\Decorators;


use App\Models\StationMlitModel;
use App\Models\TownMlitModel;

class CityListDecorator extends PrefectureListDecorator
{
    public function __construct()
    {
    }

    public function townStationList(int $cityId)
    {
        $res = [];
        $townModel = new TownMlitModel();
        $results = $townModel->townList($cityId);

        foreach ($results as $result){
            $caption = $result['town_name'] . "(" . $result['trade_count'] . ")";
            $link = "/" . $result['prefecture_alphabet'] . "/" . $result['city_alphabet'] . "/" . $result['town_id'] . "/";
            $res['town'][] = ['caption' => $caption, 'link' => $link];
        }

        $stationModel = new StationMlitModel();
        $results = $stationModel->stationList($cityId);

        foreach ($results as $result){
            $caption = $result['station_name'] . "駅(" . $result['trade_count'] . ")";
            $link = "/" . $result['prefecture_alphabet'] . "/" . $result['city_alphabet'] . "/station/" . $result['station_id'] . "/";
            $res['station'][] = ['caption' => $caption, 'link' => $link];
        }
        return $res;
    }
}
