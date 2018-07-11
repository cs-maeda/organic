<?php

namespace App\Http\Controllers\Iacsicc;

use App\Http\Controllers\Controller;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //

    public function index(ConnectionInterface $conn)
    {
        $body = [];
        $type = 'index';

        return view('iacsicc/index', ['body' => $body], ['type' => $type]);
    }

    public function area(ConnectionInterface $conn, string $prefecture, string $city = null, int $townId = null)
    {
        $body = [];
        $type = 'prefecture';

        if (isset($townId))
        {
            echo 'townId';
            exit;
        }
        if (isset($city))
        {
            echo 'city';
            exit;
        }
        echo 'prefecture';
        exit;

        return view('iacsicc/index', ['body' => $body], ['type' => $type]);
    }

}
