<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/11
 * Time: 17:12
 */

namespace App\Decorators;

use App\Models\PrefectureModel;
use App\Value\AreaValue;

class ListDecorator
{
    protected $areaValue = null;

    public function __construct(AreaValue $areaValue = null)
    {
        $this->areaValue = $areaValue;
    }

    public function prefectureList(): array
    {
        $model = new PrefectureModel();
        $res['prefecture'] = $model->prefectureList();

        return $res;
    }

}
