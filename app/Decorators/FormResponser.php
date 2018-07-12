<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/12
 * Time: 12:17
 */

namespace App\Decorators;

use App\Models\CityModel;
use App\Models\TownModel;

class FormResponser
{
    public function getJsonp($callback, $getType, $addressCode)
    {
        // コールバックが不正な文字列であれば異常終了
        if (preg_match('/[^0-9A-Za-z_]/', $callback) === 1) { die; }
        // 取得タイプが不正な文字列であれば異常終了
        if (preg_match('/[^0-9A-Za-z_]/', $getType) === 1) { die; }

        $value = $this->getValue($getType, (int)$addressCode);
        $return = $callback . '(' . json_encode($value) . ')';
        return $return;
    }

    protected function getValue($getType, $addressCode)
    {
        switch($getType)
        {
            case 'city':
            case 'allcity':
                return $this->getCityList($addressCode);
                break;
            case 'town' :
            case 'alltown' :
                return $this->getTownList($addressCode);
                break;
            case 'block' :
            case 'allblock' :
            default :
                die; // 不正なクエリは異常終了する
                break;
        }
    }

    protected function getCityList(int $prefectureId)
    {
        $results = CityModel::where('prefecture_id', '=', $prefectureId)->orderBy('city_id');

        $res = [];
        foreach ($results as $result){
            $res[$result['city_id']] = $result['city_name'];
        }
        return $res;
    }

    protected function getTownList(int $cityId)
    {
        $results = TownModel::where('city_id', '=', $cityId)->orderBy('mst_town_id');

        $res = [];
        foreach ($results as $result){
            $res[$result['mst_town_id']] = $result['town_name'];
        }
        return $res;
    }
}
