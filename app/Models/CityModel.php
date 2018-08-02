<?php

namespace App\Models;

use App\Condition\Conditioner;
use App\Models\ModelBase;
use Illuminate\Database\Eloquent\Model;

class CityModel extends ModelBase
{
    //
	public $timestamps = false;
	protected $primaryKey = 'mst_city_id';
	protected $table = 'mst_city';

    public function retrieveArea(string $prefecture, string $city)
    {
        $pdo = self::getPdo();
        $sql =
            "SELECT " .
                "mst_city.prefecture_id, " .
                "mst_city.prefecture_name, " .
                "mst_city.prefecture_alphabet, " .
                "mst_city.city_id, " .
                "mst_city.city_name, " .
                "mst_city.city_alphabet " .
            "FROM `mst_city` " .
            "WHERE " .
                "mst_city.prefecture_alphabet = ? AND " .
                "mst_city.city_alphabet = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$prefecture, $city]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function retrieveAreaById(int $prefectureId, int $cityId)
    {
        $pdo = self::getPdo();
        $sql =
            "SELECT " .
                "mst_city.prefecture_id, " .
                "mst_city.prefecture_name, " .
                "mst_city.prefecture_alphabet, " .
                "mst_city.city_id, " .
                "mst_city.city_name, " .
                "mst_city.city_alphabet " .
            "FROM `mst_city` " .
            "WHERE " .
                "mst_city.prefecture_id = ? AND " .
                "mst_city.city_id = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$prefectureId, $cityId]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function cityList(int $prefectureId, Conditioner $conditioner)
    {
        $bindArray = [];
        $bindArray[] = $prefectureId;
        $condition = $conditioner->siteCondition($bindArray);
        $pdo = self::getPdo();
        $sql =
            "SELECT " .
                "mst_city.prefecture_id, " .
                "mst_city.prefecture_name, " .
                "mst_city.prefecture_alphabet, " .
                "mst_city.city_id, " .
                "mst_city.city_name, " .
                "mst_city.city_alphabet, " .
                "tbl_trade_count.trade_count " .
            "FROM `mst_city` " .
                "LEFT JOIN tbl_trade_count ON mst_city.city_id = tbl_trade_count.area_id AND tbl_trade_count.station = 0 " .
            "WHERE " .
                "mst_city.prefecture_id = ? {$condition} " .
            "ORDER BY mst_city.city_id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($bindArray);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }


}
