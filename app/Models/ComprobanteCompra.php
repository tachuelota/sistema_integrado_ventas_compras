<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComprobanteCompra extends Model {

	use SoftDeletes;

	protected $table = 'ts_comprobantecompra';

    protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';

	public function ComprobanteDetalleCompra(){
		return $this->hasMany('App\Models\ComprobanteDetalleCompra','id_comprobante');
	}

	public function Moneda(){
		return $this->belongsTo('App\Models\Moneda','id_moneda');
	}

	public function Proveedor(){
		return $this->belongsTo('App\Models\Proveedor','id_proveedor');
	}

	public function Igv(){
		return $this->belongsTo('App\Models\Igv','id_igv');
	}

	public function DetalleNota(){
		return $this->hasMany('App\Models\DetalleNota','id_comprobanteCompra');
	}

	public function GuiaRemision(){
		return $this->hasMany('App\Models\GuiaRemision','id_comprobanteCompra');
	}

	public function DetallePago(){
		return $this->belongsToMany('App\Models\DetallePago','ts_relacion_letras','id_comprobanteCompra','id_detalle_pago');
	}

	public function DetallePagoPendiente(){
		return $this->hasMany('App\Models\DetallePago','id_comprobanteCompra');
	}

}
