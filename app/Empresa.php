<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use RelationManagerTrait,GetAllDataTrait;
    use SoftDeletes;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
		$this->addRelationApp( new \App\Plantel, 'razon' );  // generated by relation command - Plantel,Empresa
		$this->addRelationApp( new \App\Municipio, 'name' );  // generated by relation command - Municipio,Empresa
		$this->addRelationApp( new \App\Estado, 'name' );  // generated by relation command - Estado,Empresa
		$this->addRelationApp( new \App\Giro, 'name' );  // generated by relation command - Giro,Empresa
		$this->addRelationApp( new \App\Especialidad, 'name' );  // generated by relation command - Especialidad,Empresa
    } 

	//Mass Assignment
	protected $fillable = ['razon_social','nombre_contacto','tel_fijo','tel_cel','correo1','correo2','calle','no_int','no_ex','colonia','municipio_id','estado_id','cp','giro_id','plantel_id','especialidad_id','usu_alta_id','usu_mod_id'];

	public function usu_alta() {
		return $this->hasOne('App\User', 'id', 'usu_alta_id');
	}// end

	public function usu_mod() {
		return $this->hasOne('App\User', 'id', 'usu_mod_id');
	}// end


    protected $dates = ['deleted_at'];

	// generated by relation command - Plantel,Empresa - start
	public function plantel() {
		return $this->belongsTo('App\Plantel');
	}// end

	// generated by relation command - Municipio,Empresa - start
	public function municipio() {
		return $this->belongsTo('App\Municipio');
	}// end

	// generated by relation command - Estado,Empresa - start
	public function estado() {
		return $this->belongsTo('App\Estado');
	}// end

	// generated by relation command - Giro,Empresa - start
	public function giro() {
		return $this->belongsTo('App\Giro');
	}// end

	// generated by relation command - Especialidad,Empresa - start
	public function especialidad() {
		return $this->belongsTo('App\Especialidad');
	}// end
}