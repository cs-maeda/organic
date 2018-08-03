<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/08/03
 * Time: 10:46
 */

namespace App\Factories;


use App\Condition\CityConditioner;
use App\Condition\Conditioner;
use App\Condition\PrefectureConditioner;
use App\Condition\StationConditioner;
use App\Condition\TownConditioner;
use App\Value\AreaValue;

class ConditionerFactory
{
    protected $areaValue = null;
    protected $root = null;

    public function __construct(AreaValue $areaValue, string $root = null)
    {
        $this->areaValue = $areaValue;
        $this->root = $root;
    }

    public function product(): Conditioner
    {
        $conditioner = null;

        $where = $this->areaValue->where();

        switch ($where){
            case 'prefecture':
                $conditioner = PrefectureConditioner::instance($this->areaValue, $this->root);
                break;
            case 'city':
                $conditioner = CityConditioner::instance($this->areaValue, $this->root);
                break;
            case 'town':
                $conditioner = TownConditioner::instance($this->areaValue, $this->root);
                break;
            case 'station':
                $conditioner = StationConditioner::instance($this->areaValue, $this->root);
                break;
            default:
                $conditioner = Conditioner::instance($this->areaValue, $this->root);
                break;
        }
        return $conditioner;
    }
}
