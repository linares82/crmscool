<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Especialidad;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateEspecialidad;
use App\Http\Requests\createEspecialidad;

class EspecialidadsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$especialidads = Especialidad::getAllData($request);

		return view('especialidads.index', compact('especialidads'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('especialidads.create')
			->with( 'list', Especialidad::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createEspecialidad $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Especialidad::create( $input );

		return redirect()->route('especialidads.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Especialidad $especialidad)
	{
		$especialidad=$especialidad->find($id);
		return view('especialidads.show', compact('especialidad'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Especialidad $especialidad)
	{
		$especialidad=$especialidad->find($id);
		return view('especialidads.edit', compact('especialidad'))
			->with( 'list', Especialidad::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Especialidad $especialidad)
	{
		$especialidad=$especialidad->find($id);
		return view('especialidads.duplicate', compact('especialidad'))
			->with( 'list', Especialidad::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Especialidad $especialidad, updateEspecialidad $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$especialidad=$especialidad->find($id);
		$especialidad->update( $input );

		return redirect()->route('especialidads.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Especialidad $especialidad)
	{
		$especialidad=$especialidad->find($id);
		$especialidad->delete();

		return redirect()->route('especialidads.index')->with('message', 'Registro Borrado.');
	}

}