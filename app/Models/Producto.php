<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model {

	use SoftDeletes;

	protected $table = 'ts_producto';

    protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';

	public function UnidadMedida(){
		return $this->belongsTo('App\Models\UnidadMedida','id_unidad_medida');
	} 

	public function TipoProducto(){
		return $this->belongsTo('App\Models\TipoProducto','id_tipoproducto');
	} 

	public function TipoTela(){
		return $this->belongsTo('App\Models\TipoTela','id_tipotela');
	}

	public function Composicion(){
		return $this->belongsTo('App\Models\Composicion','id_composicion');
	} 

	public function Hilatura(){
		return $this->belongsTo('App\Models\Hilatura','id_hilatura');
	} 

	public function Color(){
		return $this->belongsTo('App\Models\Color','id_color');
	} 

	public function Titulo(){
		return $this->belongsTo('App\Models\Titulo','id_titulo');
	} 

}
