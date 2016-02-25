<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstadoLetra extends Model {

	use SoftDeletes;

	protected $table = 'ts_estado_letra';

    protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';

}
