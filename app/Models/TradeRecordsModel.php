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

    protected $conditioner = null;

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
                "tbl_trade_records.city_name, " .
                "tbl_trade_records.town_id, " .
                "tbl_trade_records.town_name, " .
                "tbl_trade_records.station_name, " .
                "tbl_trade_records.time_to_station, " .
                "tbl_trade_records.price, " .
                "tbl_trade_records.area, " .
                "tbl_trade_records.building_age, " .
                "tbl_trade_records.building_structure, " .
                "tbl_trade_records.land_usage, " .
                "tbl_trade_records.transaction_date, " .
                "tbl_trade_records.type_caption " .
            "FROM `tbl_trade_records` " .
            "WHERE 1 {$condition} " .
            "ORDER BY tbl_trade_records.transaction_year DESC " .
            "LIMIT {$cursor}, {$limitCount}";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($bindArray);
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $results;
    }

}
