<?php

namespace App\Models;

use App\Models\ModelBase;
use Illuminate\Database\Eloquent\Model;

class StationMlitModel extends ModelBase
{
    //
	public $timestamps = false;
	protected $primaryKey = 'mst_station_mlit_id';
	protected $table = 'mst_station_mlit';

    public function retrieveArea(int $stationId)
    {
        $pdo = self::getPdo();
        $sql =
            "SELECT " .
                "mst_city.prefecture_id, " .
                "mst_city.prefecture_name, " .
                "mst_city.city_id, " .
                "mst_city.city_name, " .
                "mst_station_mlit.station_id, " .
                "mst_station_mlit.station_name " .
            "FROM `mst_station_mlit` " .
                "LEFT JOIN mst_city ON mst_station_mlit.city_id = mst_city.city_id " .
            "WHERE mst_station_mlit.station_id = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$stationId]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function stationList(int $cityId)
    {
        $pdo = self::getPdo();
        $sql =
            "SELECT " .
                "mst_city.prefecture_id, " .
                "mst_city.prefecture_name, " .
                "mst_city.prefecture_alphabet, " .
                "mst_city.city_id, " .
                "mst_city.city_name, " .
                "mst_city.city_alphabet, " .
                "mst_station_mlit.station_id, " .
                "mst_station_mlit.station_name, " .
                "tbl_trade_count.trade_count " .
            "FROM `mst_station_mlit` " .
                "LEFT JOIN mst_city ON mst_station_mlit.city_id = mst_city.city_id " .
                "LEFT JOIN tbl_trade_count ON mst_station_mlit.station_id = tbl_trade_count.area_id AND tbl_trade_count.station = 1 " .
            "WHERE mst_city.city_id = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$cityId]);
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $results;
    }


}
