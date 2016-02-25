<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelacionNotas extends Model {

	use SoftDeletes;

	protected $table = 'ts_relacion_notas';

    protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';

	public function ComprobanteVenta(){
		return $this->belongsTo('App\Models\ComprobanteVenta','id_comprobanteVenta');
	}

	public function Nota(){
		return $this->belongsTo('App\Models\Nota','id_nota');
	}


}
