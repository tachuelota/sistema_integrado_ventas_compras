<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MotivoTraslado extends Model {

	use SoftDeletes;

	protected $table = 'ts_motivotraslado';

    protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';

}
