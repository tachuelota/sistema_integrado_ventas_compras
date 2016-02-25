<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MotivoNota extends Model {

	use SoftDeletes;

	protected $table = 'ts_motivo_nota';

    protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';

}
