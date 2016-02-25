<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transporte extends Model {

	use SoftDeletes;

	protected $table = 'ts_transporte';

    protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';
}
