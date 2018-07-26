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

    const WHOLE_OF_COUNTRY = 99;    // 全国の ID

    public function __construct(string $pwd, array $areaInfo)
    {
        $this->pwd = $pwd;
        $this->areaInfo = $areaInfo;
    }

    public function where(): string
    {
        return $this->pwd;
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

    public function parentId(): int
    {
        $parentId = 0;
        switch ($this->pwd)
        {
            case 'prefecture':
                $parentId = self::WHOLE_OF_COUNTRY;
                break;
            case 'city':
            case 'town':
            case 'station':
                $parentId = $this->areaInfo['prefecture']['id'];
                break;
            default:
                break;
        }
        return $parentId;
    }

    public function displayName(): string
    {
        $displayName = $this->displayNameImpl($this->pwd);
        return $displayName;
    }

    public function parentAreaName(): string
    {
        $parentName = '';
        switch ($this->pwd)
        {
            case 'prefecture':
                $parentName = '全国';
                break;
            case 'city':
            case 'town':
            case 'station':
                $parentName = $this->areaInfo['prefecture']['name'];
                break;
            default:
                break;
        }
        return $parentName;
    }

    public function breadcrumb(string $siteName): array
    {
        $breadcrumb = [];
        $breadcrumb[] = ['caption' => $siteName,
                         'link' => '/'];
        $pwd = $this->where();
        if (($pwd == 'prefecture')||
            ($pwd == 'city')||
            ($pwd == 'town')||
            ($pwd == 'station')){
            $link = "/{$this->areaInfo['prefecture']['alphabet']}/";
            if ($pwd == 'prefecture'){
                $link = '';
            }
            $breadcrumb[] = ['caption' => $this->areaInfo['prefecture']['name'],
                            'link' => $link];
        }
        if (($pwd == 'city')||
            ($pwd == 'town')||
            ($pwd == 'station')){
            $link = "/{$this->areaInfo['city']['alphabet']}/";
            if ($pwd == 'city'){
                $link = '';
            }
            $breadcrumb[] = ['caption' => $this->areaInfo['city']['name'],
                            'link' => $link];
        }
        if ($pwd == 'town'){
            $breadcrumb[] = ['caption' => $this->areaInfo['town']['name'],
                            'link' => ""];
        }
        if ($pwd == 'station'){
            $breadcrumb[] = ['caption' => $this->areaInfo['station']['name'] . "駅（{$this->areaInfo['city']['name']}）",
                            'link' => ""];
        }
        return $breadcrumb;
    }

    protected function displayNameImpl(string $where): string
    {
        $displayName = '';
        switch ($where)
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
        $stationName = $this->areaInfo['station']['name'] . '駅(' . $this->displayCityName() . ')';
        return $stationName;
    }

}
