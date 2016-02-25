<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model {

	use SoftDeletes;

	protected $table = 'ts_cliente';

    protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';

	public function ClienteDetalle(){
		return $this->hasOne('App\Models\ClienteDetalle','id');
	}
}
