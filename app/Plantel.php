<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plantel extends Model
{
    use RelationManagerTrait,GetAllDataTrait;
    use SoftDeletes;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
		$this->addRelationApp( new \App\Lectivo, 'name' );  // generated by relation command - Lectivo,Plantel
		$this->addRelationApp( new \App\TpoPlantel, 'name' );  // generated by relation command - Lectivo,Plantel
    } 

	//Mass Assignment
	protected $fillable = ['razon','rfc','cve_incorporacion','tel','mail','pag_web','lectivo_id',
						   'logo','slogan','membrete','usu_alta_id','usu_mod_id', 'calle', 
						   'no_int', 'no_ext', 'colonia', 'cp', 'municipio', 'estado', 'rvoe', 'cct', 
						   'tpo_plantel_id', 'meta_venta', 'cve_plantel'];

    protected $dates = ['deleted_at'];

	// generated by relation command - Lectivo,Plantel - start
	public function lectivo() {
		return $this->belongsTo('App\Lectivo');
	}// end
	public function tpo_plantel() {
		return $this->belongsTo('App\TpoPlantel');
	}// end

	public function usu_alta() {
		return $this->hasOne('App\User', 'id', 'usu_alta_id');
	}// end

	public function usu_mod() {
		return $this->hasOne('App\User', 'id', 'usu_mod_id');
	}// end
}