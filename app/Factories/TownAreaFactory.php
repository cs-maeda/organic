<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/21
 * Time: 14:10
 */

namespace App\Factories;


use App\Models\TownMlitModel;

class TownAreaFactory extends AreaFactory
{
    public function __construct(int $townId)
    {
        $result = TownMlitModel::where('id', $townId)->first();

        $this->prefectureId = $result['prefecture_id'];
        $this->cityId = $result['city_id'];
        $this->townId = $townId;
    }
}
