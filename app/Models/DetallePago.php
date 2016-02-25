<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetallePago extends Model {

	use SoftDeletes;

	protected $table = 'ts_detalle_pago';

    protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';

	public function RelacionLetras(){
		return $this->hasMany('App\Models\RelacionLetras','id_detalle_pago');
	}
	
	public function ComprobanteVenta(){
		return $this->belongsTo('App\Models\ComprobanteVenta','id_comprobanteVenta');
	}
}
