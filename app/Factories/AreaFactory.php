<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/11
 * Time: 10:18
 */

namespace App\Factories;


use App\Models\CityModel;
use App\Models\PrefectureModel;
use App\Models\StationMlitModel;
use App\Models\TownMlitModel;
use App\Value\AreaValue;

class AreaFactory
{
    protected $prefecture = '';
    protected $city = '';
    protected $townId = 0;
    protected $stationId = 0;

    protected $areaInfo = null;

    public function __construct(string $prefecture, string $city = null, int $id = null, bool $isStation = false)
    {
        $this->prefecture = $prefecture;
        if (isset($city)){
            $this->city = $city;
        }
        if (isset($id)){
            if ($isStation){
                $this->stationId = $id;
            }
            else {
                $this->townId = $id;
            }
        }
    }

    public function product(): AreaValue
    {
        $res = [];
        $pwd = '';
        if ($this->stationId > 0){
            $pwd = 'station';
            $res = $this->stationArea($this->stationId);
        }
        else if ($this->townId > 0){
            $pwd = 'town';
            $res = $this->townArea($this->townId);
        }
        else if ($this->city != ''){
            $pwd = 'city';
            $res = $this->cityArea($this->prefecture, $this->city);
        }
        else if ($this->prefecture){
            $pwd = 'prefecture';
            $res = $this->prefectureArea($this->prefecture);
        }

        $areaValue = new AreaValue($pwd, $res);
        return $areaValue;
    }

    protected function stationArea(int $stationId): array
    {
        $res = $this->initArea();

        $model = new StationMlitModel();
        $result = $model->retrieveArea($stationId);

        $res['prefecture']['id'] = $result['prefecture_id'];
        $res['prefecture']['name'] = $result['prefecture_name'];
        $res['city']['id'] = $result['city_id'];
        $res['city']['name'] = $result['city_name'];
        $res['station']['id'] = $result['station_id'];
        $res['station']['name'] = $result['station_name'];

        return $res;
    }

    protected function townArea(int $townId): array
    {
        $res = $this->initArea();

        $model = new TownMlitModel();
        $result = $model->retrieveArea($townId);

        $res['prefecture']['id'] = $result['prefecture_id'];
        $res['prefecture']['name'] = $result['prefecture_name'];
        $res['city']['id'] = $result['city_id'];
        $res['city']['name'] = $result['city_name'];
        $res['town']['id'] = $result['town_id'];
        $res['town']['name'] = $result['town_name'];

        return $res;
    }

    protected function cityArea(string $prefecture, string $city): array
    {
        $res = $this->initArea();

        $model = new CityModel();
        $result = $model->retrieveArea($prefecture, $city);

        $res['prefecture']['id'] = $result['prefecture_id'];
        $res['prefecture']['name'] = $result['prefecture_name'];
        $res['city']['id'] = $result['city_id'];
        $res['city']['name'] = $result['city_name'];

        return $res;
    }

    protected function prefectureArea(string $prefecture): array
    {
        $res = $this->initArea();

        $model = new PrefectureModel();
        $result = $model->retrieveArea($prefecture);

        $res['prefecture']['id'] = $result['prefecture_id'];
        $res['prefecture']['name'] = $result['prefecture_name'];

        return $res;
    }

    protected function initArea(): array
    {
        $res['prefecture']['name'] = '';
        $res['prefecture']['id'] = 0;
        $res['city']['name'] = '';
        $res['city']['id'] = 0;
        $res['town']['name'] = '';
        $res['town']['id'] = 0;
        $res['station']['name'] = '';
        $res['station']['id'] = 0;

        return $res;
    }

}
