<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComprobanteDetalleCompra extends Model {

	use SoftDeletes;

	protected $table = 'ts_detallecomprobantecompra';

    protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';

	public function Producto(){
		return $this->belongsTo('App\Models\Producto','id_producto');
	}
}
