<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoNota extends Model {

	use SoftDeletes;

	protected $table = 'ts_tipo_nota';

    protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';

}
