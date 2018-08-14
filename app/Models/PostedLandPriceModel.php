<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/08/14
 * Time: 15:01
 */

namespace App\Models;


class PostedLandPriceModel extends ModelBase
{
    public $timestamps = false;
    protected $primaryKey = 'tbl_posted_land_price_id';
    protected $table = 'tbl_posted_land_price';

}
