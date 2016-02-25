<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComprobanteVenta extends Model {

	use SoftDeletes;

	protected $table = 'ts_comprobanteventa';

    protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';

	public function ComprobanteDetalleVenta(){
		return $this->hasMany('App\Models\ComprobanteDetalleVenta','id_comprobanteVenta');
	}

	public function Moneda(){
		return $this->belongsTo('App\Models\Moneda','id_moneda');
	}

	public function ClienteDetalle(){
		return $this->belongsTo('App\Models\ClienteDetalle','id_detalle_cliente');
	}

	public function Igv(){
		return $this->belongsTo('App\Models\Igv','id_igv');
	}

	// public function DetalleNota(){
	// 	return $this->hasMany('App\Models\DetalleNota','id_comprobanteVenta');
	// }

	public function GuiaRemision(){
		return $this->hasMany('App\Models\GuiaRemision','id_comprobanteVenta');
	}

	public function DetallePago(){
		return $this->belongsToMany('App\Models\DetallePago','ts_relacion_letras','id_comprobanteVenta','id_detalle_pago');
	}

	public function DetalleNota(){
		return $this->belongsToMany('App\Models\Nota','ts_relacion_notas','id_comprobanteVenta','id_nota');
	}
	
	public function DetallePagoPendiente(){
		return $this->hasMany('App\Models\DetallePago','id_comprobanteVenta');
	}

}
