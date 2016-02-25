<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Titulo extends Model {

	use SoftDeletes;

	protected $table = 'ts_titulo';

    protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';
}
