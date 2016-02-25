<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banco extends Model {

	use SoftDeletes;

	protected $table = 'ts_banco';

    protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';

}
