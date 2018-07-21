<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/21
 * Time: 14:09
 */

namespace App\Factories;


use App\Models\CityModel;

class CityAreaFactory extends AreaFactory
{
    public function __construct(int $cityId)
    {
        $results = CityModel::where('city_id', $cityId)->first();
        $prefectureId = $results['prefecture_id'];

        $this->prefectureId = $prefectureId;
        $this->cityId = $cityId;
    }
}
