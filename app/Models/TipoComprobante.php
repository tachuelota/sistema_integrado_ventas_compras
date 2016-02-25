<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoComprobante extends Model {

	use SoftDeletes;

	protected $table = 'ts_tipocomprobante';

    protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';

	/*
	public function Transporte(){
		return $this->belongsTo('App\Models\Transporte','id_transporte');
	}
	*/
}