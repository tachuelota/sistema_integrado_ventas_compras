<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hilatura extends Model {

	use SoftDeletes;

	protected $table = 'ts_hilatura';

    protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';
}
