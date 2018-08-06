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
    protected $prefecture = null;
    protected $prefectureId = null;
    protected $city = null;
    protected $cityId = null;
    protected $townId = null;
    protected $stationId = null;

    protected $areaInfo = null;

    public function __construct(string $prefecture = null, string $city = null, int $id = null, bool $isStation = false)
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
        if (isset($this->stationId)){
            $pwd = 'station';
            $res = $this->stationArea($this->stationId);
        }
        else if (isset($this->townId)){
            $pwd = 'town';
            $res = $this->townArea($this->townId);
        }
        else if (isset($this->city)){
            $pwd = 'city';
            $res = $this->cityArea($this->prefecture, $this->city);
        }
        else if (isset($this->cityId)){
            $pwd = 'city';
            $res = $this->cityIdArea($this->prefectureId, $this->cityId);
        }
        else if (isset($this->prefecture)){
            $pwd = 'prefecture';
            $res = $this->prefectureArea($this->prefecture);
        }
        else if (isset($this->prefectureId)){
            $pwd = 'prefecture';
            $res = $this->prefectureIdArea($this->prefectureId);
        }
        else {
            $pwd = 'top';
            $res = [];
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
        $res['prefecture']['alphabet'] = $result['prefecture_alphabet'];
        $res['city']['id'] = $result['city_id'];
        $res['city']['name'] = $result['city_name'];
        $res['city']['alphabet'] = $result['city_alphabet'];
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
        $res['prefecture']['alphabet'] = $result['prefecture_alphabet'];
        $res['city']['id'] = $result['city_id'];
        $res['city']['name'] = $result['city_name'];
        $res['city']['alphabet'] = $result['city_alphabet'];
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
        $res['prefecture']['alphabet'] = $result['prefecture_alphabet'];
        $res['city']['id'] = $result['city_id'];
        $res['city']['name'] = $result['city_name'];
        $res['city']['alphabet'] = $result['city_alphabet'];

        return $res;
    }

    protected function cityIdArea(int $prefectureId, int $cityId): array
    {
        $res = $this->initArea();

        $model = new CityModel();
        $result = $model->retrieveAreaById($prefectureId, $cityId);

        $res['prefecture']['id'] = $result['prefecture_id'];
        $res['prefecture']['name'] = $result['prefecture_name'];
        $res['prefecture']['alphabet'] = $result['prefecture_alphabet'];
        $res['city']['id'] = $result['city_id'];
        $res['city']['name'] = $result['city_name'];
        $res['city']['alphabet'] = $result['city_alphabet'];

        return $res;
    }

    protected function prefectureArea(string $prefecture): array
    {
        $res = $this->initArea();

        $model = new PrefectureModel();
        $result = $model->retrieveArea($prefecture);

        $res['prefecture']['id'] = $result['prefecture_id'];
        $res['prefecture']['name'] = $result['prefecture_name'];
        $res['prefecture']['alphabet'] = $result['prefecture_alphabet'];

        return $res;
    }

    protected function prefectureIdArea(int $prefectureId): array
    {
        $res = $this->initArea();

        $model = new PrefectureModel();
        $result = $model->retrieveAreaById($prefectureId);

        $res['prefecture']['id'] = $result['prefecture_id'];
        $res['prefecture']['name'] = $result['prefecture_name'];
        $res['prefecture']['alphabet'] = $result['prefecture_alphabet'];

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
