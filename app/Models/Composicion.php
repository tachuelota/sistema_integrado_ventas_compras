<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Composicion extends Model {

	use SoftDeletes;

	protected $table = 'ts_composicion';

    protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';

}
