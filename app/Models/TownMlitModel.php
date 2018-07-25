<?php

namespace App\Models;

use App\Models\ModelBase;
use Illuminate\Database\Eloquent\Model;

class TownMlitModel extends ModelBase
{
    //
	public $timestamps = false;
	protected $primaryKey = 'id';
	protected $table = 'mst_town_mlit';

    public function retrieveArea(int $townId)
    {
        $pdo = self::getPdo();
        $sql =
            "SELECT " .
                "mst_town_mlit.prefecture_id, " .
                "mst_town_mlit.prefecture_name, " .
                "mst_town_mlit.city_id, " .
                "mst_town_mlit.city_name, " .
                "mst_town_mlit.town_id, " .
                "mst_town_mlit.town_name " .
            "FROM `mst_town_mlit` " .
            "WHERE mst_town_mlit.town_id = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$townId]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function townList(int $cityId): array
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
                "mst_town_mlit.town_id AS town_id, " .
                "mst_town_mlit.town_name, " .
                "tbl_trade_count.trade_count " .
            "FROM `mst_town_mlit` " .
                "LEFT JOIN mst_city ON mst_town_mlit.city_id = mst_city.city_id " .
                "LEFT JOIN tbl_trade_count ON mst_town_mlit.town_id = tbl_trade_count.area_id AND tbl_trade_count.station = 0 " .
            "WHERE mst_city.city_id = ? AND mst_town_mlit.town_id > 0";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$cityId]);
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $results;
    }


}
