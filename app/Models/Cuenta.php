<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cuenta extends Model {

	use SoftDeletes;

	protected $table = 'ts_cuenta';

    protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';

}
