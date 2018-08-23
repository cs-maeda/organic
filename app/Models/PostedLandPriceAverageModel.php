<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/08/22
 * Time: 9:56
 */

namespace App\Models;


class PostedLandPriceAverageModel extends ModelBase
{
    public $timestamps = false;
    protected $primaryKey = 'tbl_posted_land_price_average_id';
    protected $table = 'tbl_posted_land_price_average';

    public function average(int $areaId)
    {
        $pdo = self::getPdo();
        $sql = "SELECT * FROM tbl_posted_land_price_average WHERE area_id = ? ORDER BY year";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$areaId]);
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $results;
    }

    public function japanAverage()
    {
        $pdo = self::getPdo();
        $sql =
            "INSERT INTO tbl_posted_land_price_average (area_id, year, average) " .
            "SELECT " .
                "0 AS area_id, " .
                "year, " .
                "AVG(price) AS average_price " .
            "FROM `tbl_posted_land_price` GROUP BY year";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public function prefectureAverage()
    {
        $pdo = self::getPdo();
        $sql =
            "INSERT INTO tbl_posted_land_price_average (area_id, year, average) " .
            "SELECT " .
                "mst_city.prefecture_id, " .
                "year, " .
                "AVG(price) AS average_price " .
            "FROM `tbl_posted_land_price` " .
                "LEFT JOIN mst_city ON tbl_posted_land_price.city_id = mst_city.city_id " .
            "GROUP BY year, mst_city.prefecture_id " .
            "ORDER BY mst_city.prefecture_id, year";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public function cityAverage()
    {
        $pdo = self::getPdo();
        $sql =
            "INSERT INTO tbl_posted_land_price_average (area_id, year, average) " .
            "SELECT " .
                "city_id, " .
                "year, " .
                "AVG(price) AS average_price " .
            "FROM `tbl_posted_land_price` " .
            "GROUP BY year, city_id " .
            "ORDER BY city_id, year";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }
}
