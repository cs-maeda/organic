<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/11
 * Time: 17:17
 */

namespace App\Decorators;


use App\Models\CityModel;

class PrefectureListDecorator extends ListDecorator
{
    public function __construct()
    {
    }

    public function cityList(int $prefectureId): array
    {
        $model = new CityModel();
        $results = $model->cityList($prefectureId);

        $res = [];
        foreach ($results as $result){
            $caption = $result['city_name'] . "(" . $result['trade_count'] . ")";
            $link = "/" . $result['prefecture_alphabet'] . "/" . $result['city_alphabet'] . "/";
            $res['city'][] = ['caption' => $caption, 'link' => $link];
        }
        return $res;
    }

}
