<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/09/10
 * Time: 14:12
 */

namespace App\Helper\iacsicc;


use App\Helper\SitemapBaseHelper;
use App\Models\SitemapUrlModel;

class SitemapHelper extends SitemapBaseHelper
{
    const IACS_ICC_CREATOR_ID = 6;

    public function city()
    {
        $model = new SitemapUrlModel();
        $condition =
            "SELECT " .
                "CONCAT(?, '/', mst_city.prefecture_alphabet, '/', mst_city.city_alphabet, '/') AS url, " .
                "? AS creator_id " .
            "FROM `mst_city` " .
                "LEFT JOIN tbl_trade_count ON mst_city.city_id = tbl_trade_count.area_id " .
            "WHERE " .
                "tbl_trade_count.site_number = 0 AND " .
                "tbl_trade_count.station = 0";

        $model->insertSitemap($condition, [$this->host, $this->creatorId]);
    }

    public function town()
    {
        $model = new SitemapUrlModel();
        $condition =
            "SELECT " .
                "CONCAT(?, '/', mst_city.prefecture_alphabet, '/', mst_city.city_alphabet, '/', mst_town_mlit.town_id, '/') AS url, " .
                "? AS creator_id " .
            "FROM `mst_town_mlit` " .
                "LEFT JOIN mst_city ON mst_town_mlit.city_id = mst_city.city_id " .
                "LEFT JOIN tbl_trade_count ON mst_town_mlit.town_id = tbl_trade_count.area_id " .
            "WHERE " .
                "tbl_trade_count.site_number = 0 AND " .
                "tbl_trade_count.station = 0 AND " .
                "mst_town_mlit.town_id > 10000000";

        $model->insertSitemap($condition, [$this->host, $this->creatorId]);
    }

    public function station()
    {
        $model = new SitemapUrlModel();
        $condition =
            "SELECT " .
                "CONCAT(?, '/', mst_city.prefecture_alphabet, '/', mst_city.city_alphabet, '/station/', mst_station_mlit.station_id, '/') AS url, " .
                "? AS creator_id " .
            "FROM `mst_station_mlit` " .
                "LEFT JOIN mst_city ON mst_station_mlit.city_id = mst_city.city_id " .
                "LEFT JOIN tbl_trade_count ON mst_station_mlit.station_id = tbl_trade_count.area_id " .
            "WHERE " .
                "tbl_trade_count.site_number = 0 AND " .
                "tbl_trade_count.station = 1";

        $model->insertSitemap($condition, [$this->host, $this->creatorId]);
    }
}
