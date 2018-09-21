<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/09/10
 * Time: 17:18
 */

namespace App\Helper\ginatonic;

use App\Helper\SitemapBaseHelper;
use App\Models\SitemapUrlModel;

class SitemapHelper extends SitemapBaseHelper
{
    public function city()
    {
        $model = new SitemapUrlModel();
        $condition =
            "SELECT " .
                "CONCAT(?, '/', mst_city.prefecture_alphabet, '/',mst_city.city_alphabet, '/'), " .
                "? AS creator_id " .
            "FROM `tbl_trade_count` " .
                "LEFT JOIN mst_city ON tbl_trade_count.area_id = mst_city.city_id " .
            "WHERE " .
                "tbl_trade_count.site_number = ? AND " .
                "tbl_trade_count.station = 0 AND " .
                "tbl_trade_count.area_id > 100 " .
            "GROUP BY mst_city.prefecture_alphabet, mst_city.city_alphabet " .
            "ORDER BY mst_city.city_id";

        $model->insertSitemap($condition, [$this->host, $this->creatorId, $this->siteNumber]);
    }
}
