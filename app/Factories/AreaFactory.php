<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/11
 * Time: 10:18
 */

namespace App\Factories;


use App\Value\AreaValue;

class AreaFactory
{
    protected $prefecture = '';
    protected $city = '';
    protected $townId = 0;
    protected $stationId = 0;

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
        $areaValue = new AreaValue();
        return $areaValue;
    }
}
