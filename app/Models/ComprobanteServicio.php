<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComprobanteServicio extends Model {

	use SoftDeletes;

	protected $table = 'ts_comprobanteservicio';

    protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';

	public function ComprobanteDetalleServicio(){
		return $this->hasMany('App\Models\ComprobanteDetalleServicio','id_comprobanteServicio');
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
}
