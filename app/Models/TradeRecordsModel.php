<?php

namespace App;

use App\Models\ModelBase;
use Illuminate\Database\Eloquent\Model;

class TradeRecordsModel extends ModelBase
{
    //
    public $timestamps = false;
    protected $primaryKey = 'tbl_trade_records_id';
    protected $table = 'tbl_trade_records';

    public function averagePrefecture(int $prefectureId): array
    {
        $pdo = self::getPdo();
        $sql =
            "SELECT MIN(price) AS min_price, MAX(price) AS max_price, AVG(price) AS avg_price " .
            "FROM `tbl_trade_records` WHERE prefecture_id = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$prefectureId]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function averageCity(int $cityId): array
    {
        $pdo = self::getPdo();
        $sql =
            "SELECT MIN(price) AS min_price, MAX(price) AS max_price, AVG(price) AS avg_price " .
            "FROM `tbl_trade_records` WHERE city_id = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$cityId]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function averageTown(int $townId): array
    {
        $pdo = self::getPdo();
        $sql =
            "SELECT MIN(price) AS min_price, MAX(price) AS max_price, AVG(price) AS avg_price " .
            "FROM `tbl_trade_records` WHERE town_id = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$townId]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function averageStation(int $stationId): array
    {
        $pdo = self::getPdo();
        $sql =
            "SELECT MIN(price) AS min_price, MAX(price) AS max_price, AVG(price) AS avg_price " .
            "FROM `tbl_trade_records` WHERE station_id = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$stationId]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }
}
