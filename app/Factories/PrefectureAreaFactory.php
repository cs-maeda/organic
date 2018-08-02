<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/21
 * Time: 13:34
 */

namespace App\Factories;


class PrefectureAreaFactory extends AreaFactory
{
    public function __construct(int $prefectureId)
    {
        $this->prefectureId = $prefectureId;
    }
}
