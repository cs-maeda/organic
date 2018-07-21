<?php

namespace App\Models;

use App\Condition\Conditioner;
use App\Models\ModelBase;
use Illuminate\Database\Eloquent\Model;

class TradeRecordsModel extends ModelBase
{
    //
    public $timestamps = false;
    protected $primaryKey = 'tbl_trade_records_id';
    protected $table = 'tbl_trade_records';

    protected $conditioner;

    public function __construct(Conditioner $conditioner)
    {
        parent::__construct();

        $this->conditioner = $conditioner;
    }

    public function retrieve(int $cursor, int $limitCount)
    {
        $pdo = self::getPdo();

        $bindArray = [];
        $condition = $this->conditioner->tradeTableCondition($bindArray);
        $sql =
            "SELECT " .
                "tbl_trade_records.prefecture_id, " .
                "tbl_trade_records.city_id, " .
                "tbl_trade_records.town_id, " .
                "tbl_trade_records.station_name, " .
                "tbl_trade_records.time_to_station, " .
                "tbl_trade_records.price, " .
                "tbl_trade_records.area, " .
                "tbl_trade_records.building_age, " .
                "tbl_trade_records.building_structure, " .
                "tbl_trade_records.land_usage, " .
                "tbl_trade_records.transaction_date, " .
                "tbl_trade_type.caption, " .
                "mst_town_mlit.city_name, " .
                "mst_town_mlit.town_name " .
            "FROM `tbl_trade_records` " .
                "LEFT JOIN tbl_trade_type ON tbl_trade_records.type = tbl_trade_type.type " .
                "LEFT JOIN mst_town_mlit ON tbl_trade_records.town_id = mst_town_mlit.id " .
                "LEFT JOIN mst_station_mlit ON tbl_trade_records.station_id = mst_station_mlit.station_id " .
            "WHERE 1 {$condition} " .
            "LIMIT {$cursor}, {$limitCount}";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($bindArray);
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $results;
    }

}
