<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/11
 * Time: 17:17
 */

namespace App\Decorators;


use App\Condition\PrefectureConditioner;
use App\Models\CityModel;
use App\Value\AreaValue;

class PrefectureListDecorator extends ListDecorator
{
    public function __construct(AreaValue $areaValue)
    {
        parent::__construct($areaValue);
    }

    public function cityList(int $prefectureId): array
    {
        $conditioner = PrefectureConditioner::instance($this->areaValue);

        $model = new CityModel();
        $results = $model->cityList($prefectureId, $conditioner);

        $res = [];
        foreach ($results as $result){
            $tradeCount = ($result['trade_count'] == null) ? 0 : $result['trade_count'];
            $caption = $result['city_name'] . "(" . $tradeCount . ")";
            $link = "/" . $result['prefecture_alphabet'] . "/" . $result['city_alphabet'] . "/";
            if ($tradeCount === 0){
                $link = '';
            }
            $res['city'][] = ['caption' => $caption, 'link' => $link];
        }
        return $res;
    }

}
