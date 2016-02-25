<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoProducto extends Model {

	use SoftDeletes;

	protected $table = 'ts_tipoproducto';

    protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';
}
