<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoCambioMoneda extends Model {

	use SoftDeletes;

	protected $table = 'ts_tipocambiomoneda';

    protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';

}
