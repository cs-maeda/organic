<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/11
 * Time: 17:12
 */

namespace App\Decorators;

use App\Models\PrefectureModel;

class ListDecorator
{
    public function __construct()
    {
    }

    public function prefectureList(): array
    {
        $model = new PrefectureModel();
        $res['prefecture'] = $model->prefectureList();

        return $res;
    }

}
