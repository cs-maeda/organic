<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/11
 * Time: 17:17
 */

namespace App\Decorators;


use App\Models\CityModel;

class PrefectureListDecorator extends ListDecorator
{
    public function __construct()
    {
    }

    public function cityList(int $prefectureId)
    {
        $model = new CityModel();
        $res['city'] = $model->cityList($prefectureId);

        return $res;
    }

}
