<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class AsignacionAcademica extends Model
{
    use RelationManagerTrait,GetAllDataTrait;
    use SoftDeletes;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
		$this->addRelationApp( new \App\Empleado, 'nombre' );  // generated by relation command - Empleado,AsignacionAcademica
		$this->addRelationApp( new \App\Grupo, 'name' );  // generated by relation command - Grupo,AsignacionAcademica
		$this->addRelationApp( new \App\Materium, 'name' );  // generated by relation command - Grupo,AsignacionAcademica
		$this->addRelationApp( new \App\Plantel, 'razon' );  // generated by relation command - Grupo,AsignacionAcademica
		$this->addRelationApp( new \App\Lectivo, 'name' );  // generated by relation command - Grupo,AsignacionAcademica
    } 

	//Mass Assignment
	protected $fillable = ['lectivo_id', 'empleado_id','materium_id','grupo_id','horas','usu_alta_id','usu_mod_id', 'plantel_id'];

	public function usu_alta() {
		return $this->hasOne('App\User', 'id', 'usu_alta_id');
	}// end

	public function usu_mod() {
		return $this->hasOne('App\User', 'id', 'usu_mod_id');
	}// end


    protected $dates = ['deleted_at'];

	// generated by relation command - Empleado,AsignacionAcademica - start
	public function empleado() {
		return $this->belongsTo('App\Empleado');
	}// end

	public function employee() {
		return $this->belongsTo('App\Empleado');
	}// end

	// generated by relation command - Grupo,AsignacionAcademica - start
	public function grupo() {
		return $this->belongsTo('App\Grupo');
	}// end

	// generated by relation command - Grupo,AsignacionAcademica - start
	public function materia() {
		return $this->belongsTo('App\Materium', 'materium_id', 'id');
	}// end

	// generated by relation command - Grupo,AsignacionAcademica - start
	public function plantel() {
		return $this->belongsTo('App\Plantel');
	}// end

	// generated by relation command - Grupo,AsignacionAcademica - start
	public function lectivo() {
		return $this->belongsTo('App\Lectivo');
	}// end

	public function horarios() {
		return $this->hasMany('App\Horario');
	}// end
        
}