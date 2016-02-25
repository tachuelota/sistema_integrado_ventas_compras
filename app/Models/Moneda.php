<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Moneda extends Model {

	use SoftDeletes;

	protected $table = 'ts_moneda';

    protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';

}
