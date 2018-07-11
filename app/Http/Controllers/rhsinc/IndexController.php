<?php

namespace App\Http\Controllers\rhsinc;

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

		return view('rhsinc/welcome2', ['body' => $body], ['type' => $type]);
	}

}
