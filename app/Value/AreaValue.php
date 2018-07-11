<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/11
 * Time: 10:00
 */

namespace App\Value;

class AreaValue
{
    protected $pwd = '';
    protected $areaInfo = [];

    public function __construct(string $pwd, array $areaInfo)
    {
        $this->pwd = $pwd;
        $this->areaInfo = $areaInfo;
    }

    public function prefectureName(): string
    {
        return $this->areaInfo['prefecture']['name'];
    }

    public function prefectureId(): int
    {
        return $this->areaInfo['prefecture']['id'];
    }

    public function cityName(): string
    {
        return $this->areaInfo['city']['name'];
    }

    public function cityId(): int
    {
        return $this->areaInfo['city']['id'];
    }

    public function townName(): string
    {
        return $this->areaInfo['town']['name'];
    }

    public function townId(): int
    {
        return $this->areaInfo['town']['id'];
    }

    public function stationName(): string
    {
        return $this->areaInfo['station']['id'];
    }

    public function stationId(): int
    {
        return $this->areaInfo['station']['id'];
    }

    public function displayName(): string
    {
        $displayName = '';
        switch ($this->pwd)
        {
            case 'prefecture':
                $displayName = $this->areaInfo['prefecture']['name'];
                break;
            case 'city':
                $displayName = $this->displayCityName();
                break;
            case 'town':
                $displayName = $this->displayTownName();
                break;
            case 'station':
                $displayName = $this->displayStationName();
                break;
            default:
                break;
        }
        return $displayName;
    }

    protected function displayCityName(): string
    {
        $cityName = $this->areaInfo['city']['name'];
        if (($this->areaInfo['prefecture']['id'] == 13) &&
            ($cityName == '中央区' || $cityName == '港区' || $cityName == '北区')) {
            $cityName = $this->areaInfo['prefecture']['name'] . $this->areaInfo['city']['name'];
        }
        if (($cityName == '府中市') || ($cityName == '伊達市')) {
            $cityName = $this->areaInfo['prefecture']['name'] . $this->areaInfo['city']['name'];
        }
        return $cityName;
    }

    protected function displayTownName(): string
    {
        $townName = $this->areaInfo['city']['name'] . $this->areaInfo['town']['name'];
        if ($townName == '府中市府中町'){
            $townName = $this->areaInfo['prefecture']['name'] . $this->areaInfo['city']['name'] . $this->areaInfo['town']['name'];
        }
        return $townName;
    }

    protected function displayStationName(): string
    {
        $stationName = $this->areaInfo['station']['name'] . '(' . $this->displayCityName() . ')';
        return $stationName;
    }

}
