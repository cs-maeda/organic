<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/09/11
 * Time: 14:24
 */

namespace App\Models;


class SitemapCreatorModel extends ModelBase
{
    public $timestamps = false;
    protected $primaryKey = 'creator_id';
    protected $table = 'sitemap_creator';

}
