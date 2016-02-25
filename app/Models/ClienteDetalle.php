<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClienteDetalle extends Model {

	use SoftDeletes;

	protected $table = 'ts_detallecliente';

    protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';

	
	public function Cliente(){
		return $this->belongsTo('App\Models\Cliente','id_cliente');
	}
	
	public function IndicadorDireccionCliente(){
		return $this->belongsTo('App\Models\IndicadorDireccionCliente','id_indicadorDireccion');
	}
}