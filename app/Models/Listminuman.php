<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Listminuman extends Eloquent {
	protected $collection = 'listminuman';

	public $timestamps = false;

	public $primaryKey = '_id';

	protected $fillable = ["_id", "nama_minuman", "harga", "deskripsi_minuman", "status"];
}
