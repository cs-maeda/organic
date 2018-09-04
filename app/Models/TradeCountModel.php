<?php

namespace App\Models;

use App\Condition\Conditioner;
use App\Models\ModelBase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TradeCountModel extends ModelBase
{
    //
    public $timestamps = false;
    protected $primaryKey = 'tbl_trade_count_id';
    protected $table = 'tbl_trade_count';

    public function clearTable(array $sites)
    {
        $pdo = self::getPdo();
        $sql = "DELETE FROM tbl_trade_count WHERE site_number IN (";
        foreach ($sites as $site){
            $sql .= "?,";
        }
        $sql = substr($sql, 0, -1);
        $sql .= ")";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($sites);
    }

    public function getTradeCount(string $domainName, int $prefectureId): array
    {
        $siteNumber = 0;
        $condition = '';
        if ($domainName == 'rhs-inc.com'){
            $siteNumber = 1;
            $condition = ' AND tbl_trade_records.type = 1 ';
        }

        $pdo = self::getPdo();
        $sql =
            "SELECT " .
                "mst_city.city_id AS area_id, " .
                "0 AS station, " .
                "COUNT(mst_city.city_id) AS trade_count " .
            "FROM mst_city " .
                "LEFT JOIN `tbl_trade_records` ON mst_city.city_id = tbl_trade_records.city_id " .
            "WHERE mst_city.prefecture_id = ? {$condition}" .
            "GROUP BY mst_city.city_id ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$prefectureId]);

        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $results;
    }

    public function importCityTradeCount(string $domainName, int $prefectureId)
    {
        $siteNumber = 0;
        $condition = '';
        if ($domainName == 'rhs-inc.com'){
            $siteNumber = 1;
            $condition = ' AND tbl_trade_records.type = 1 ';
        }
        DB::insert(
            "INSERT INTO tbl_trade_count (site_number, area_id, station, trade_count) " .
                    "SELECT " .
                        "{$siteNumber} AS site_number, " .
                        "mst_city.city_id AS area_id, " .
                        "0 AS station, " .
                        "COUNT(mst_city.city_id) AS trade_count " .
                    "FROM mst_city " .
                        "LEFT JOIN `tbl_trade_records` ON mst_city.city_id = tbl_trade_records.city_id " .
                    "WHERE " .
                        "mst_city.prefecture_id = ? AND " .
                        "tbl_trade_records.town_id != 0 {$condition}" .
                    "GROUP BY mst_city.city_id", [$prefectureId]);
    }

    public function importTownTradeCount(string $domainName, int $cityId)
    {
        $siteNumber = 0;
        $condition = '';
        if ($domainName == 'rhs-inc.com'){
            $siteNumber = 1;
            $condition = ' AND tbl_trade_records.type = 1 ';
        }
        DB::insert(
            "INSERT INTO tbl_trade_count (site_number, area_id, station, trade_count) " .
                "SELECT " .
                    "{$siteNumber} AS site_number, " .
                    "mst_town_mlit.town_id AS area_id, " .
                    "0 AS station, " .
                    "COUNT(mst_town_mlit.town_id) AS trade_count " .
                "FROM mst_town_mlit " .
                    "LEFT JOIN `tbl_trade_records` ON mst_town_mlit.town_id = tbl_trade_records.town_id " .
                "WHERE " .
                    "mst_town_mlit.city_id = ? AND " .
                    "mst_town_mlit.town_id != 0 AND " .
                    "tbl_trade_records.town_id != 0  {$condition}" .
                "GROUP BY mst_town_mlit.town_id " .
                "ORDER BY mst_town_mlit.town_id ", [$cityId]);
    }

    public function importStationTradeCount(string $domainName, int $cityId)
    {
        echo 'station' . PHP_EOL;

        $siteNumber = 0;
        $condition = '';
        if ($domainName == 'rhs-inc.com'){
            $siteNumber = 1;
            $condition = ' AND tbl_trade_records.type = 1 ';
        }
        DB::insert(
            "INSERT INTO tbl_trade_count (site_number, area_id, station, trade_count) " .
                    "SELECT " .
                        "{$siteNumber} AS site_number, " .
                        "station.station_id AS area_id, " .
                        "1 AS station, " .
                        "COUNT(station.station_id) AS trade_count " .
                    "FROM " .
                    "(" .
                        "SELECT " .
                        "prefecture_id, " .
                        "city_id, " .
                        "station_id, " .
                        "station_name " .
                        "FROM mst_station_mlit " .
                        "GROUP BY prefecture_id, city_id, station_id, station_name " .
                    ") AS station " .
                        "LEFT JOIN `tbl_trade_records` ON station.station_id = tbl_trade_records.station_id " .
                        "LEFT JOIN mst_city ON mst_city.city_id = station.city_id " .
                    "WHERE station.city_id = ? AND station.station_id != 0 {$condition}" .
                    "GROUP BY station.station_id, station.station_name " .
                    "ORDER BY station.station_id ", [$cityId]);
    }

    public function importStandardPointCount()
    {
        $siteNumber = Conditioner::SITE_NUMBER_GINATONIC;

        $pdo = self::getPdo();
        $sql =
            "INSERT INTO tbl_trade_count (site_number, area_id, station, trade_count) " .
            "SELECT " .
                "{$siteNumber} AS site_number, " .
                "view_posted_land_price.city_id AS area_id, " .
                "0 AS station, " .
                "COUNT(view_posted_land_price.city_id) AS trade_count " .
            "FROM view_posted_land_price " .
                "LEFT JOIN mst_city ON view_posted_land_price.city_id = mst_city.city_id " .
            "GROUP BY view_posted_land_price.city_id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

}
