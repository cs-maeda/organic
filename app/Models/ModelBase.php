<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2017/07/31
 * Time: 16:42
 */

namespace App\Models;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Eloquent\Model;
use PDO;
use Illuminate\Support\Facades\DB;

class ModelBase extends Model
{
    public function getPdo(): PDO
    {
        $pdo = DB::connection()->getPdo();
        return $pdo;
    }

    public function connection(): ConnectionInterface
    {
        $conn = DB::connection();
        return $conn;
    }

}
