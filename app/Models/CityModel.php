<?php

namespace App\Models;

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
                "mst_city.city_id, " .
                "mst_city.city_name " .
            "FROM `mst_city` " .
            "WHERE " .
                "mst_city.prefecture_alphabet = ? AND " .
                "mst_city.city_alphabet = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$prefecture, $city]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function cityList(int $prefectureId)
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
                "mst_city.prefecture_id = ? " .
            "ORDER BY mst_city.city_id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$prefectureId]);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }


}
