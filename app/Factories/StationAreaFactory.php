<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/21
 * Time: 14:11
 */

namespace App\Factories;


use App\Models\StationMlitModel;

class StationAreaFactory extends AreaFactory
{
    public function __construct(int $stationId)
    {
        $result = StationMlitModel::where('station_id', $stationId)->first();

        $this->prefectureId = $result['prefecture_id'];
        $this->cityId = $result['city_id'];
        $this->stationId = $stationId;
    }
}
