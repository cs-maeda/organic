<?php

namespace App\Models;

use App\Models\ModelBase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TradeCountModel extends ModelBase
{
    //
    public $timestamps = false;
    protected $primaryKey = 'tbl_trade_count_id';
    protected $table = 'tbl_trade_count';

    public function clearTable()
    {
        $pdo = self::getPdo();
        $sql = "DELETE FROM tbl_trade_count";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $sql = "ALTER TABLE tbl_trade_count AUTO_INCREMENT = 1";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public function getTradeCount(int $prefectureId): array
    {
        $pdo = self::getPdo();
        $sql =
            "SELECT " .
                "mst_city.city_id AS area_id, " .
                "0 AS station, " .
                "COUNT(mst_city.city_id) AS trade_count " .
            "FROM mst_city " .
                "LEFT JOIN `tbl_trade_records` ON mst_city.city_id = tbl_trade_records.city_id " .
            "WHERE mst_city.prefecture_id = ? " .
            "GROUP BY mst_city.city_id ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$prefectureId]);

        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $results;
    }

    public function importCityTradeCount(int $prefectureId)
    {
        DB::insert(
            "INSERT INTO tbl_trade_count (area_id, station, trade_count) " .
                    "SELECT " .
                    "mst_city.city_id AS area_id, " .
                    "0 AS station, " .
                    "COUNT(mst_city.city_id) AS trade_count " .
                    "FROM mst_city " .
                    "LEFT JOIN `tbl_trade_records` ON mst_city.city_id = tbl_trade_records.city_id " .
                    "WHERE mst_city.prefecture_id = ? " .
                    "GROUP BY mst_city.city_id", [$prefectureId]);
    }

    public function importTownTradeCount(int $cityId)
    {
        DB::insert(
            "INSERT INTO tbl_trade_count (area_id, station, trade_count) " .
                "SELECT " .
                "mst_town_mlit.town_id AS area_id, " .
                "0 AS station, " .
                "COUNT(mst_town_mlit.town_id) AS trade_count " .
                "FROM mst_town_mlit " .
                "LEFT JOIN `tbl_trade_records` ON mst_town_mlit.town_id = tbl_trade_records.town_id " .
                "WHERE mst_town_mlit.city_id = ? AND mst_town_mlit.town_id != 0 " .
                "GROUP BY mst_town_mlit.town_id " .
                "ORDER BY mst_town_mlit.town_id ", [$cityId]);
    }

    public function importStationTradeCount(int $cityId)
    {
        echo 'station' . PHP_EOL;
        DB::insert(
            "INSERT INTO tbl_trade_count (area_id, station, trade_count) " .
                "SELECT " .
                    "mst_station_mlit.station_id AS area_id, " .
                    "1 AS station, " .
                    "COUNT(mst_station_mlit.station_id) AS trade_count " .
                "FROM mst_station_mlit " .
                    "LEFT JOIN `tbl_trade_records` ON mst_station_mlit.station_id = tbl_trade_records.station_id " .
                "WHERE mst_station_mlit.city_id = ? " .
                "GROUP BY mst_station_mlit.station_id " .
                "ORDER BY mst_station_mlit.station_id ", [$cityId]);
    }

}
