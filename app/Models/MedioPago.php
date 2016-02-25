<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedioPago extends Model {

	use SoftDeletes;

	protected $table = 'ts_medio_pago';

    protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';
}
