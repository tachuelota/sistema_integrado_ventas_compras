<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nota extends Model {

	use SoftDeletes;

	protected $table = 'ts_nota';

    protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';

	public function TipoNota(){
		return $this->belongsTo('App\Models\TipoNota','id_tipo_nota');
	}

	public function Moneda(){
		return $this->belongsTo('App\Models\Moneda','id_moneda');
	}

	public function ComprobanteVenta(){
		return $this->belongsToMany('App\Models\ComprobanteVenta','ts_relacion_notas','id_nota','id_comprobanteVenta');
	}
}
