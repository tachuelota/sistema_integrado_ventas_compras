<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelacionLetras extends Model {

	use SoftDeletes;

	protected $table = 'ts_relacion_letras';

    protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';


	public function ComprobanteVenta(){
		return $this->belongsTo('App\Models\ComprobanteVenta','id_comprobanteVenta');
	}

	public function DetallePago(){
		return $this->belongsTo('App\Models\DetallePago','id_detalle_pago');
	}

}
