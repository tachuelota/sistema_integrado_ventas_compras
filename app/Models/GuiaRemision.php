<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuiaRemision extends Model {

	use SoftDeletes;

	protected $table = 'ts_guiaremision';

    protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';

	public function GuiaRemisionDetalle(){
		return $this->hasMany('App\Models\GuiaRemisionDetalle','id_guiaRemision');
	}
	
	public function ClienteDetalle(){
		return $this->belongsTo('App\Models\ClienteDetalle','id_detalle_cliente');
	}

	public function Proveedor(){
		return $this->belongsTo('App\Models\Proveedor','id_proveedor');
	}

	public function Igv(){
		return $this->belongsTo('App\Models\Igv','id_igv');
	}
}
