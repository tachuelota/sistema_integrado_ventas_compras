<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KardexProducto extends Model {

	use SoftDeletes;

	protected $table = 'ts_kardex_producto';

    protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';

	public function Producto(){
		return $this->belongsTo('App\Models\Producto','id_producto');
	}
}
