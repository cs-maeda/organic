<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/09/10
 * Time: 16:03
 */

namespace App\Helper;


use Illuminate\Http\Request;
use App\Models\SitemapUrlModel;

abstract class SitemapBaseHelper
{
    protected $siteNumber = null;
    protected $creatorId = null;
    protected $host = null;

    public function __construct(Request $request, int $siteNumber, int $creatorId)
    {
        $this->siteNumber = $siteNumber;
        $this->creatorId = $creatorId;
        $this->host = $request->root();
    }

    public function clear()
    {
        SitemapUrlModel::where('creator_id', $this->creatorId)->delete();
    }

    public function top()
    {
        $model = new SitemapUrlModel();
        $model->insertSitemap("SELECT ? AS url, ? AS creator_id", [$this->host, $this->creatorId]);
    }

    public function prefecture()
    {
        $model = new SitemapUrlModel();
        $condition =
            "SELECT " .
                "CONCAT(?, '/', mst_prefecture.prefecture_alphabet, '/') AS url, " .
                "? AS creator_id " .
            "FROM `mst_prefecture`";

        $model->insertSitemap($condition, [$this->host, $this->creatorId]);
    }

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
                "tbl_trade_count.site_number = ? AND " .
                "tbl_trade_count.station = 0";

        $model->insertSitemap($condition, [$this->host, $this->creatorId, $this->siteNumber]);
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
                "tbl_trade_count.site_number = ? AND " .
                "tbl_trade_count.station = 0 AND " .
                "mst_town_mlit.town_id > 10000000";

        $model->insertSitemap($condition, [$this->host, $this->creatorId, $this->siteNumber]);
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
                "tbl_trade_count.site_number = ? AND " .
                "tbl_trade_count.station = 1";

        $model->insertSitemap($condition, [$this->host, $this->creatorId, $this->siteNumber]);
    }

}
