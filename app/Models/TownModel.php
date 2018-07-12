<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/12
 * Time: 12:35
 */

namespace App\Models;


class TownModel extends ModelBase
{
    public $timestamps = false;
    protected $primaryKey = 'mst_town_id';
    protected $table = 'mst_town';

}
