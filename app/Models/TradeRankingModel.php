<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/20
 * Time: 9:17
 */

namespace App\Models;


use App\Condition\Conditioner;
use Mockery\Exception;

class TradeRankingModel extends ModelBase
{
    //
    public $timestamps = false;
    protected $primaryKey = 'tbl_trade_ranking_id';
    protected $table = 'tbl_trade_ranking';

    public function clearTable(int $siteNumber)
    {
        $pdo = self::getPdo();
        $sql = "DELETE FROM tbl_trade_ranking WHERE site_number = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$siteNumber]);
    }

    public function figure(Conditioner $conditioner, int $prefectureId, int $areaId, int $station = 0)
    {
        $bindArray = [];
        $bindArray[] = $prefectureId;
        $bindArray[] = $areaId;
        $bindArray[] = $station;
        $condition = $conditioner->siteCondition($bindArray);

        $pdo = self::getPdo();
        $sql = "SELECT * FROM tbl_trade_ranking WHERE prefecture_id = ? AND area_id = ? AND station = ? {$condition}";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($bindArray);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        $bindArray = [];
        $bindArray[] = $areaId;
        $bindArray[] = $station;
        $condition = $conditioner->siteCondition($bindArray);
        // 駅は都道府県を跨いで、取引事例がある場合があるので全てのレコードを SUM する.
        $sql = "SELECT SUM(trade_count) as trade_count FROM tbl_trade_ranking WHERE area_id = ? AND station = ? {$condition}";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($bindArray);
        $res = $stmt->fetch(\PDO::FETCH_ASSOC);
        $result['trade_count'] = $res['trade_count'];

        return $result;
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
                    "prefecture_id, " .
                    "ranking, " .
                    "area_id, " .
                    "station, " .
                    "avg_price, " .
                    "min_price, " .
                    "max_price, " .
                    "trade_count " .
                ") " .
            "SELECT " .
                "{$siteNumber} AS site_number, " .
                "0 AS prefecture_id, " .
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

//        echo $sql . PHP_EOL . PHP_EOL;

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
                    "prefecture_id, " .
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
                        "0 AS prefecture_id, " .
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

//        echo $sql . PHP_EOL . PHP_EOL;

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
                    "prefecture_id, " .
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
                    "{$prefectureId} AS prefecture_id, " .
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

//        echo '$prefectureId = ' . $prefectureId . PHP_EOL;
//        echo $sql . PHP_EOL . PHP_EOL;

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
                    "prefecture_id, " .
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
                        "{$prefectureId} AS prefecture_id, " .
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

//        echo '$prefectureId = ' . $prefectureId . PHP_EOL;
//        echo $sql . PHP_EOL . PHP_EOL;

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$prefectureId]);
    }

    /**
     * @param string $domainName
     * @param int $prefectureId
     *
     * @note 駅ランキングは、取引数が都道府県を跨ぐ場合があるので注意が必要
     *       例）相模原駅 神奈川県で 807 件、 東京都町田市で 18 件 とか....
     *
     */
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
                    "prefecture_id, " .
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
                    "{$prefectureId} AS prefecture_id, " .
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

//        echo '$prefectureId = ' . $prefectureId . PHP_EOL;
//        echo $sql . PHP_EOL . PHP_EOL;

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$prefectureId]);
    }

    public function importPostedPricePrefectureRanking()
    {
        $pdo = self::getPdo();
        $sql =
            "INSERT INTO " .
                "tbl_trade_ranking " .
                "( " .
                    "ranking, " .
                    "site_number, " .
                    "prefecture_id, " .
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
                        "2 AS site_number, " .
                        "0 AS prefecture_id, " .
                        "mst_city.prefecture_id AS area_id, " .
                        "0 AS station, " .
                        "AVG(price) AS avg_price, " .
                        "MIN(price) AS min_price, " .
                        "MAX(price) AS max_price, " .
                        "0 AS trade_count " .
                    "FROM `view_posted_land_price` " .
                        "LEFT JOIN mst_city ON view_posted_land_price.city_id = mst_city.city_id " .
                    "GROUP BY mst_city.prefecture_id " .
                    "ORDER BY avg_price DESC " .
                ") AS ranking_table; ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public function importPostedPriceCityRanking(int $prefectureId)
    {
        $pdo = self::getPdo();
        $sql =
            "INSERT INTO " .
                "tbl_trade_ranking " .
                "( " .
                    "ranking, " .
                    "site_number, " .
                    "prefecture_id, " .
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
                        "2 AS site_number, " .
                        "{$prefectureId} AS prefecture_id, " .
                        "mst_city.city_id AS area_id, " .
                        "0 AS station, " .
                        "AVG(price) AS avg_price, " .
                        "MIN(price) AS min_price, " .
                        "MAX(price) AS max_price, " .
                        "0 AS trade_count " .
                    "FROM `view_posted_land_price` " .
                        "LEFT JOIN mst_city ON view_posted_land_price.city_id = mst_city.city_id " .
                    "WHERE " .
                        "prefecture_id = ? " .
                    "GROUP BY mst_city.city_id " .
                    "ORDER BY avg_price DESC " .
                ") AS ranking_table";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$prefectureId]);
    }

    public function importPostedPriceCityRankingInJapan()
    {
        $pdo = self::getPdo();
        $sql =
            "INSERT INTO " .
                "tbl_trade_ranking " .
                "( " .
                    "ranking, " .
                    "site_number, " .
                    "prefecture_id, " .
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
                        "2 AS site_number, " .
                        "0 AS prefecture_id, " .
                        "mst_city.city_id AS area_id, " .
                        "0 AS station, " .
                        "AVG(price) AS avg_price, " .
                        "MIN(price) AS min_price, " .
                        "MAX(price) AS max_price, " .
                        "0 AS trade_count " .
                    "FROM `view_posted_land_price` " .
                        "LEFT JOIN mst_city ON view_posted_land_price.city_id = mst_city.city_id " .
                    "GROUP BY mst_city.city_id " .
                    "ORDER BY avg_price DESC " .
                ") AS ranking_table";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public function createPostedLandPriceLast()
    {
        $this->dropPostedLandPriceLast();

        $pdo = self::getPdo();
        $sql =
            "CREATE TABLE `tbl_trade_ranking_last` " .
            "( " .
                "`tbl_trade_ranking_id` int(10) UNSIGNED NOT NULL, " .
                "`site_number` tinyint(1) UNSIGNED NOT NULL COMMENT 'サイト種別 0:不動産, 1:土地', " .
                "`prefecture_id` int(2) UNSIGNED NOT NULL COMMENT '都道府県ID', " .
                "`area_id` int(10) UNSIGNED NOT NULL COMMENT 'ランキングエリアID', " .
                "`station` int(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '駅ランキング識別子', " .
                "`ranking` int(10) UNSIGNED NOT NULL COMMENT '県内（国内）のランキング', " .
                "`avg_price` double UNSIGNED NOT NULL COMMENT '平均価格', " .
                "`min_price` bigint(20) UNSIGNED NOT NULL COMMENT '最低価格', " .
                "`max_price` bigint(20) UNSIGNED NOT NULL COMMENT '最高価格', " .
                "`trade_count` int(10) UNSIGNED DEFAULT NULL COMMENT '取引数', " .
                "`year_over_year` float DEFAULT NULL COMMENT '前年比' " .
            ") ENGINE=InnoDB DEFAULT CHARSET=utf8";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $sql =
            "ALTER TABLE `tbl_trade_ranking_last` " .
                "ADD PRIMARY KEY (`tbl_trade_ranking_id`), " .
                "ADD KEY `site_number` (`site_number`), " .
                "ADD KEY `area_station_id` (`area_id`,`station`,`site_number`) USING BTREE, " .
                "ADD KEY `prefecture_id` (`prefecture_id`)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $sql =
            "ALTER TABLE `tbl_trade_ranking_last` " .
                "MODIFY `tbl_trade_ranking_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public function dropPostedLandPriceLast()
    {
        $pdo = self::getPdo();
        $sql = "DROP TABLE IF EXISTS `tbl_trade_ranking_last`";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public function importPostedPricePrefectureRankingLast()
    {
        $pdo = self::getPdo();
        $sql =
            "INSERT INTO " .
                "tbl_trade_ranking_last " .
                "( " .
                    "ranking, " .
                    "site_number, " .
                    "prefecture_id, " .
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
                        "2 AS site_number, " .
                        "0 AS prefecture_id, " .
                        "mst_city.prefecture_id AS area_id, " .
                        "0 AS station, " .
                        "AVG(price) AS avg_price, " .
                        "MIN(price) AS min_price, " .
                        "MAX(price) AS max_price, " .
                        "0 AS trade_count " .
                    "FROM `view_posted_land_price_last` " .
                        "LEFT JOIN mst_city ON view_posted_land_price_last.city_id = mst_city.city_id " .
                    "GROUP BY mst_city.prefecture_id " .
                    "ORDER BY avg_price DESC " .
                ") AS ranking_table; ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public function importPostedPriceCityRankingLast(int $prefectureId)
    {
        $pdo = self::getPdo();
        $sql =
            "INSERT INTO " .
                "tbl_trade_ranking_last " .
                "( " .
                    "ranking, " .
                    "site_number, " .
                    "prefecture_id, " .
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
                        "2 AS site_number, " .
                        "{$prefectureId} AS prefecture_id, " .
                        "mst_city.city_id AS area_id, " .
                        "0 AS station, " .
                        "AVG(price) AS avg_price, " .
                        "MIN(price) AS min_price, " .
                        "MAX(price) AS max_price, " .
                        "0 AS trade_count " .
                    "FROM `view_posted_land_price_last` " .
                        "LEFT JOIN mst_city ON view_posted_land_price_last.city_id = mst_city.city_id " .
                    "WHERE " .
                        "prefecture_id = ? " .
                    "GROUP BY mst_city.city_id " .
                    "ORDER BY avg_price DESC " .
                ") AS ranking_table";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$prefectureId]);
    }

    public function makeYearOverYear()
    {
        $pdo = self::getPdo();
        $sql =
            "UPDATE " .
                "tbl_trade_ranking, " .
                "( " .
                    "SELECT " .
                        "tbl_trade_ranking.site_number, " .
                        "tbl_trade_ranking.prefecture_id, " .
                        "tbl_trade_ranking.area_id, " .
                        "tbl_trade_ranking.avg_price AS current_average, " .
                        "tbl_trade_ranking_last.avg_price AS last_average, " .
                        "((tbl_trade_ranking.avg_price / tbl_trade_ranking_last.avg_price) - 1) * 100 AS rate " .
                    "FROM `tbl_trade_ranking` " .
                        "LEFT JOIN tbl_trade_ranking_last ON " .
                            "tbl_trade_ranking.site_number = tbl_trade_ranking_last.site_number AND " .
                            "tbl_trade_ranking.prefecture_id = tbl_trade_ranking_last.prefecture_id AND " .
                            "tbl_trade_ranking.area_id = tbl_trade_ranking_last.area_id " .
                    "WHERE tbl_trade_ranking.site_number = 2 " .
                ") AS year_over_year " .
            "SET tbl_trade_ranking.year_over_year = year_over_year.rate " .
            "WHERE " .
                "tbl_trade_ranking.site_number = 2 AND " .
                "tbl_trade_ranking.prefecture_id = year_over_year.prefecture_id AND " .
                "tbl_trade_ranking.area_id = year_over_year.area_id ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public function prefectureRanking(): array
    {
        $pdo = self::getPdo();
        $sql =
            "SELECT " .
                "mst_prefecture.prefecture_id, " .
                "mst_prefecture.prefecture_name, " .
                "mst_prefecture.prefecture_alphabet, " .
                "tbl_trade_ranking.ranking, " .
                "tbl_trade_ranking.avg_price, " .
                "tbl_trade_ranking.year_over_year " .
            "FROM `tbl_trade_ranking` " .
                "LEFT JOIN mst_prefecture ON tbl_trade_ranking.area_id = mst_prefecture.prefecture_id " .
            "WHERE site_number = 2 AND tbl_trade_ranking.prefecture_id = 0 AND area_id < 99 " .
            "ORDER BY tbl_trade_ranking.ranking";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function cityRankingInJapan(): array
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
                "tbl_trade_ranking.ranking, " .
                "tbl_trade_ranking.avg_price, " .
                "tbl_trade_ranking.year_over_year " .
            "FROM `tbl_trade_ranking` " .
                "LEFT JOIN mst_city ON tbl_trade_ranking.area_id = mst_city.city_id " .
            "WHERE site_number = 2 AND tbl_trade_ranking.prefecture_id = 0 AND area_id > 1000 " .
            "ORDER BY tbl_trade_ranking.avg_price DESC " .
            "LIMIT 100";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function cityRankingInPrefecture(int $prefectureId): array
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
                "tbl_trade_ranking.ranking, " .
                "tbl_trade_ranking.avg_price, " .
                "tbl_trade_ranking.year_over_year " .
            "FROM `tbl_trade_ranking` " .
                "LEFT JOIN mst_city ON tbl_trade_ranking.area_id = mst_city.city_id " .
            "WHERE site_number = 2 AND tbl_trade_ranking.prefecture_id = ? " .
            "ORDER BY tbl_trade_ranking.avg_price DESC " .
            "LIMIT 30";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$prefectureId]);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function cityRankingIncreaseOrder(int $prefectureId): array
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
                "tbl_trade_ranking.ranking, " .
                "tbl_trade_ranking.avg_price, " .
                "tbl_trade_ranking.year_over_year " .
            "FROM `tbl_trade_ranking` " .
                "LEFT JOIN mst_city ON tbl_trade_ranking.area_id = mst_city.city_id " .
            "WHERE site_number = 2 AND tbl_trade_ranking.prefecture_id = ? " .
            "ORDER BY tbl_trade_ranking.year_over_year DESC " .
            "LIMIT 30";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$prefectureId]);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }
}
