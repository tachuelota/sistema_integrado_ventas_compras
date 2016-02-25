<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedor extends Model {

	use SoftDeletes;

	protected $table = 'ts_proveedor';

    protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';

}