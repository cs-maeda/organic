<?php

namespace App\Models;

use App\Models\ModelBase;
use Illuminate\Database\Eloquent\Model;

class PrefectureModel extends ModelBase
{
    //
	public $timestamps = false;
	protected $primaryKey = 'mst_prefecture_id';
	protected $table = 'mst_prefecture';

    public function retrieveArea(string $prefecture)
    {
        $pdo = self::getPdo();
        $sql =
            "SELECT " .
                "mst_prefecture.prefecture_id, " .
                "mst_prefecture.prefecture_name, " .
                "mst_prefecture.prefecture_alphabet " .
            "FROM `mst_prefecture` " .
            "WHERE " .
                "mst_prefecture.prefecture_alphabet = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$prefecture]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function retrieveAreaById(int $prefectureId)
    {
        $pdo = self::getPdo();
        $sql =
            "SELECT " .
                "mst_prefecture.prefecture_id, " .
                "mst_prefecture.prefecture_name, " .
                "mst_prefecture.prefecture_alphabet " .
            "FROM `mst_prefecture` " .
            "WHERE " .
                "mst_prefecture.prefecture_id = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$prefectureId]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function prefectureList()
    {
        $pdo = self::getPdo();
        $sql =
            "SELECT " .
                "mst_prefecture.prefecture_id, " .
                "mst_prefecture.prefecture_name, " .
                "mst_prefecture.prefecture_alphabet " .
            "FROM `mst_prefecture` " .
            "ORDER BY mst_prefecture.mst_prefecture_id ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $results;
    }
}
