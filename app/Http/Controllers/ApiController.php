<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/07/12
 * Time: 16:00
 */

namespace App\Http\Controllers;

use App\Models\CityModel;
use App\Models\TownModel;
use Illuminate\Database\ConnectionInterface;

class ApiController extends Controller
{
    protected $conn;

    public function __construct(ConnectionInterface $conn)
    {
        $this->conn = $conn;
    }

    public function cityList(int $prefectureId)
    {
        $results = CityModel::where('prefecture_id', $prefectureId)->orderBy('city_id')->get();

        $res = [];
        foreach ($results as $result){
            $res[$result['city_id']] = $result['city_name'];
        }
        return response()->json($res);
    }

    public function townList(int $cityId)
    {
        $results = TownModel::where('city_id', $cityId)->orderBy('mst_town_id')->get();

        $res = [];
        foreach ($results as $result){
            if ($result['town_name'] == ''){
                continue;
            }
            $res[$result['mst_town_id']] = $result['town_name'];
        }
        return json_encode($res);
    }
}
