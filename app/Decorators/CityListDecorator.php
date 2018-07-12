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
        $townModel = new TownMlitModel();
        $res['town'] = $townModel->townList($cityId);

        $stationModel = new StationMlitModel();
        $res['station'] = $stationModel->stationList($cityId);

        return $res;
    }
}
