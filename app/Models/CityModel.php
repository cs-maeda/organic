<?php

namespace App;

use App\Models\ModelBase;
use Illuminate\Database\Eloquent\Model;

class CityModel extends ModelBase
{
    //
	public $timestamps = false;
	protected $primaryKey = 'mst_city_id';
	protected $table = 'mst_city';





}
