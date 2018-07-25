<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/20
 * Time: 9:17
 */

namespace App\Models;


class TradeRankingModel extends ModelBase
{
    //
    public $timestamps = false;
    protected $primaryKey = 'tbl_trade_ranking_id';
    protected $table = 'tbl_trade_ranking';

    public function figure(int $areaId)
    {
        $pdo = self::getPdo();
        $sql = 'SELECT * FROM tbl_trade_ranking WHERE area_id = ?';

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$areaId]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function clearTable()
    {
        $pdo = self::getPdo();
        $sql = 'DELETE FROM tbl_trade_ranking';
// TRUNCATE TABLE

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $sql = 'ALTER TABLE tbl_trade_ranking AUTO_INCREMENT = 1';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public function importJapanAverage(string $domainName)
    {
        $siteNumber = 0;
        $condition = '';
        if ($domainName == 'rhs-inc.com'){
            $siteNumber = 1;
            $condition = ' AND type = 1 ';
        }

        $pdo = self::getPdo();
        $sql =
            "INSERT INTO " .
                "tbl_trade_ranking " .
                "( " .
                    "site_number, " .
                    "ranking, " .
                    "area_id, " .
                    "station, " .
                    "avg_price, " .
                    "min_price, " .
                    "max_price, " .
                    "trade_count " .
                ") " .
            "SELECT " .
                "0 AS site_number, " .
                "0 AS ranking, " .
                "99 AS area_id, " .
                "0 AS station, " .
                "AVG(price) AS avg_price, " .
                "MIN(price) AS min_price, " .
                "MAX(price) AS max_price, " .
                "COUNT(price) AS trade_count " .
            "FROM tbl_trade_records " .
            "WHERE " .
                "transaction_year IN (2017, 2016, 2015, 2014, 2013) {$condition}";

        echo $sql . PHP_EOL . PHP_EOL;

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public function importPrefectureRanking(string $domainName)
    {
        $siteNumber = 0;
        $condition = '';
        if ($domainName == 'rhs-inc.com'){
            $siteNumber = 1;
            $condition = ' AND type = 1 ';
        }

        $pdo = self::getPdo();
        $sql =
            "INSERT INTO " .
                "tbl_trade_ranking " .
                "( " .
                    "ranking, " .
                    "site_number, " .
                    "area_id, " .
                    "station, " .
                    "avg_price, " .
                    "min_price, " .
                    "max_price, " .
                    "trade_count " .
                ") " .
            "SELECT " .
                "(@num := @num + 1) AS ranking, " .
                "ranking_table.* " .
            "FROM " .
                "(SELECT @num:=0) AS dummy, " .
                "( " .
                    "SELECT " .
                        "{$siteNumber} AS site_number, " .
                        "prefecture_id AS area_id, " .
                        "0 AS station, " .
                        "AVG(price) AS avg_price, " .
                        "MIN(price) AS min_price, " .
                        "MAX(price) AS max_price, " .
                        "COUNT(price) AS trade_count " .
                    "FROM " .
                        "`tbl_trade_records` " .
                    "WHERE " .
                        "transaction_year IN (2017, 2016, 2015, 2014, 2013) {$condition}" .
                    "GROUP BY prefecture_id " .
                    "ORDER BY avg_price DESC " .
                ") AS ranking_table";

        echo $sql . PHP_EOL . PHP_EOL;

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public function importCityRanking(string $domainName, int $prefectureId)
    {
        $siteNumber = 0;
        $condition = '';
        if ($domainName == 'rhs-inc.com'){
            $siteNumber = 1;
            $condition = ' AND type = 1 ';
        }

        $pdo = self::getPdo();
        $sql =
            "INSERT INTO " .
                "tbl_trade_ranking " .
                "( " .
                    "ranking, " .
                    "site_number, " .
                    "area_id, " .
                    "station, " .
                    "avg_price, " .
                    "min_price, " .
                    "max_price, " .
                    "trade_count " .
                ") " .
            "SELECT " .
                "(@num := @num + 1) AS ranking, " .
                "ranking_table.* " .
            "FROM " .
                "(SELECT @num:=0) AS dummy, " .
                "( " .
                "SELECT " .
                    "{$siteNumber} AS site_number, " .
                    "city_id AS area_id, " .
                    "0 AS station, " .
                    "AVG(price) AS avg_price, " .
                    "MIN(price) AS min_price, " .
                    "MAX(price) AS max_price, " .
                    "COUNT(price) AS trade_count " .
                "FROM " .
                    "`tbl_trade_records` " .
                "WHERE " .
                    "transaction_year IN (2017, 2016, 2015, 2014, 2013) AND " .
                    "prefecture_id = ? {$condition}" .
                "GROUP BY city_id " .
                "ORDER BY avg_price DESC " .
                ") AS ranking_table ";

        echo '$prefectureId = ' . $prefectureId . PHP_EOL;
        echo $sql . PHP_EOL . PHP_EOL;

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$prefectureId]);
    }

    public function importTownRanking(string $domainName, int $prefectureId)
    {
        $siteNumber = 0;
        $condition = '';
        if ($domainName == 'rhs-inc.com'){
            $siteNumber = 1;
            $condition = ' AND type = 1 ';
        }

        $pdo = self::getPdo();
        $sql =
            "INSERT INTO " .
                "tbl_trade_ranking " .
                "( " .
                    "ranking, " .
                    "site_number, " .
                    "area_id, " .
                    "station, " .
                    "avg_price, " .
                    "min_price, " .
                    "max_price, " .
                    "trade_count " .
                ") " .
            "SELECT " .
                "(@num := @num + 1) AS ranking, " .
                "ranking_table.* " .
            "FROM " .
                "(SELECT @num:=0) AS dummy, " .
                "( " .
                    "SELECT " .
                        "{$siteNumber} AS site_number, " .
                        "town_id AS area_id, " .
                        "0 AS station, " .
                        "AVG(price) AS avg_price, " .
                        "MIN(price) AS min_price, " .
                        "MAX(price) AS max_price, " .
                        "COUNT(price) AS trade_count " .
                    "FROM " .
                        "`tbl_trade_records` " .
                    "WHERE " .
                        "transaction_year IN (2017, 2016, 2015, 2014, 2013) AND " .
                        "prefecture_id = ? {$condition}" .
                    "GROUP BY town_id " .
                    "ORDER BY avg_price DESC " .
                ") AS ranking_table ";

        echo '$prefectureId = ' . $prefectureId . PHP_EOL;
        echo $sql . PHP_EOL . PHP_EOL;

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$prefectureId]);
    }

    public function importStationRanking(string $domainName, int $prefectureId)
    {
        $siteNumber = 0;
        $condition = '';
        if ($domainName == 'rhs-inc.com'){
            $siteNumber = 1;
            $condition = ' AND type = 1 ';
        }

        $pdo = self::getPdo();
        $sql =
            "INSERT INTO " .
                "tbl_trade_ranking " .
                "( " .
                    "ranking, " .
                    "site_number, " .
                    "area_id, " .
                    "station, " .
                    "avg_price, " .
                    "min_price, " .
                    "max_price, " .
                    "trade_count " .
                ") " .
            "SELECT " .
                "(@num := @num + 1) AS ranking, " .
                "ranking_table.* " .
            "FROM " .
                "(SELECT @num:=0) AS dummy, " .
                "( " .
                "SELECT " .
                    "{$siteNumber} AS site_number, " .
                    "station_id AS area_id, " .
                    "1 AS station, " .
                    "AVG(price) AS avg_price, " .
                    "MIN(price) AS min_price, " .
                    "MAX(price) AS max_price, " .
                    "COUNT(price) AS trade_count " .
                "FROM " .
                    "`tbl_trade_records` " .
                "WHERE " .
                    "transaction_year IN (2017, 2016, 2015, 2014, 2013) AND " .
                    "prefecture_id = ? {$condition}" .
                "GROUP BY station_id " .
                "ORDER BY avg_price DESC " .
                ") AS ranking_table ";

        echo '$prefectureId = ' . $prefectureId . PHP_EOL;
        echo $sql . PHP_EOL . PHP_EOL;

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$prefectureId]);
    }


}
