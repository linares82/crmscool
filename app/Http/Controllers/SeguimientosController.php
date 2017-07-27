<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Seguimiento;
use App\Empleado;
use App\Cliente;
use App\StSeguimiento;
use App\AsignacionTarea;
use App\Aviso;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateSeguimiento;
use App\Http\Requests\createSeguimiento;
use App\Http\Requests\updateAsignacionTarea;
use DB;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class SeguimientosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$seguimientos = Seguimiento::getAllData($request);

		return view('seguimientos.index', compact('seguimientos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('seguimientos.create')
			->with( 'list', Seguimiento::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSeguimiento $request)
	{
		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;
		$input_seguimiento['mes']=date('m');

		//create data
		Seguimiento::create( $input );

		return redirect()->route('seguimientos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Seguimiento $seguimiento, updateAsignaciontarea $request)
	{
		/*$seguimiento=$seguimiento->join('st_seguimientos as st', 'st.id', '=', 'seguimientos.st_seguimiento_id')
								->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
								->where('cliente_id', '=', $id)->first();
		*/
		//dd($seguimiento);
		$seguimiento=$seguimiento->where('cliente_id', '=', $id)->first();
		if(!isset($seguimiento->id)){
			$input_seguimiento['cliente_id']=$id;
			$input_seguimiento['estatus_id']=1;
			$input_seguimiento['usu_alta_id']=Auth::user()->id;
			$input_seguimiento['usu_mod_id']=Auth::user()->id;
			$seguimiento=Seguimiento::create($input_seguimiento);
		}
		//$seguimiento->getAllData();
		$sts=StSeguimiento::pluck('name', 'id');
		$asignacionTareas = AsignacionTarea::where('cliente_id', '=', $seguimiento->cliente_id)->get();
		$avisos=Aviso::select('avisos.id','a.name','avisos.detalle', 'avisos.fecha',
							Db::Raw('DATEDIFF(avisos.fecha,CURDATE()) as dias_restantes'))
					->join('asuntos as a', 'a.id', '=', 'avisos.asunto_id')
					->where('seguimiento_id', '=', $seguimiento->id)
					->where('avisos.activo', '=', '1')
					->get();
		//$dias=round((strtotime($a->fecha)-strtotime(date('Y-m-d')))/86400);
		//dd($seguimiento);
		return view('seguimientos.show', compact('seguimiento', 'sts', 'asignacionTareas', 'avisos'))
					->with( 'list', AsignacionTarea::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Seguimiento $seguimiento)
	{
		$seguimiento=$seguimiento->find($id);
		return view('seguimientos.edit', compact('seguimiento'))
			->with( 'list', Seguimiento::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Seguimiento $seguimiento)
	{
		$seguimiento=$seguimiento->find($id);
		return view('seguimientos.duplicate', compact('seguimiento'))
			->with( 'list', Seguimiento::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Seguimiento $seguimiento, updateSeguimiento $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$seguimiento=$seguimiento->find($id);
		$seguimiento->update( $input );

		return redirect()->route('seguimientos.show', $seguimiento->cliente_id)->with('message', 'Registro Actualizado.');
	}

	public function updateEstatus($id, Seguimiento $seguimiento, updateSeguimiento $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$seguimiento=$seguimiento->find($id);
		$seguimiento->update( $input );

		return redirect()->route('seguimientos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Seguimiento $seguimiento)
	{
		$seguimiento=$seguimiento->find($id);
		$seguimiento->delete();

		return redirect()->route('seguimientos.index')->with('message', 'Registro Borrado.');
	}

	public function reporteSeguimientosXEmpleado(){
		$estatus=$_REQUEST['estatus'];
		$e=Empleado::where('user_id', '=', Auth::user()->id)->first();
		$mes=(int)date('m');
		$fecha=date('d-m-Y');
		
		$seguimientos=Seguimiento::select('c.nombre as Nombre', 'c.nombre2 as Segundo Nombre', 'c.ape_paterno as Apellido_Paterno', 'c.ape_materno as Apellido_Materno',
			'c.calle as Calle', 'c.no_interior as No_Interior', 'c.no_exterior as No_Exterior', 'm.name as Municipio', 'e.name as Estado', 
			'c.tel_fijo as Teléfono_Fijo', 'tel_cel as Teléfono_Celular', 'mail as Correo_Electrónico', 'sts.name as Estatus_Seguimiento', 
			'stc.name as Estatus_Cliente')
			->join('st_seguimientos as sts', 'sts.id', '=', 'seguimientos.estatus_id')
			->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
			->join('municipios as m', 'm.id', '=', 'c.municipio_id')
			->join('estados as e', 'e.id', '=', 'c.estado_id')
			->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
			//->leftJoin('asignacion_tareas as at', 'at.cliente_id', '=','seguimientos.cliente_id')
			->where('mes', '=', $mes)
			->where('c.plantel_id', '=', $e->plantel_id)
			->where('c.empleado_id', '=', $e->id)
			->where('seguimientos.estatus_id', '=', $estatus)
			->get()->toArray();
		//dd($seguimientos);
			/*PDF::setOptions(['defaultFont' => 'arial']);
			$pdf = PDF::loadView('seguimientos.reportes.seguimientosXempleado', array('seguimientos'=>$seguimientos, 'fecha'=>$fecha, 'e'=>$e))
						->setPaper('letter', 'landscape');
			return $pdf->download('reporte.pdf');
			*/
		//return view('seguimientos.reportes.seguimientosXempleado', compact('seguimientos', 'fecha', 'e'));			
		Excel::create('Laravel Excel', function($excel) use($seguimientos) {
            $excel->sheet('Productos', function($sheet) use($seguimientos) {
                $sheet->fromArray($seguimientos);
            });
        })->export('xls');
	}

	public function seguimientosXempleadoG()
	{
		return view('seguimientos.reportes.seguimientosXempleadoG')
			->with( 'list', Cliente::getListFromAllRelationApps())
			->with( 'list1', Seguimiento::getListFromAllRelationApps());
	}

	public function seguimientosXempleadoGr(updateSeguimiento $request)
	{
		$input=$request->all();
		$fecha=date('d-m-Y');
		
		/*$seguimientos=Seguimiento::select(
				'p.razon','emp.nombre as nombre_e','emp.ape_paterno as paterno_e','emp.ape_materno as materno_e',
				'cli.nombre as nombre_c','cli.nombre2 as nombre2_c','cli.ape_paterno as paterno_c',
				'cli.ape_materno as materno_c','cli.calle','cli.no_interior','cli.no_exterior','cli.colonia',
				'm.name as municipio', 'est.name as estado','cli.tel_fijo','cli.tel_cel', 'cli.mail',
				'stc.name as estatus_cliente','sts.name as estatus_seguimiento' 
				)
				->join('clientes as cli', 'cli.id', '=','seguimientos.cliente_id')
				->join('municipios as m', 'm.id', '=', 'cli.municipio_id')
				->join('estados as est', 'est.id', '=', 'cli.estado_id')
				->join('empleados as emp', 'emp.id', '=', 'cli.empleado_id')
				->join('plantels as p', 'p.id', '=', 'cli.plantel_id')
				->join('st_clientes as stc', 'stc.id', '=', 'cli.st_cliente_id')
				->join('st_seguimientos as sts', 'sts.id', '=', 'seguimientos.estatus_id')
				->whereBetween('cli.empleado_id', [$input['empleado_f'], $input['empleado_t']])
				->whereBetween('cli.plantel_id', [$input['plantel_f'], $input['plantel_t']])
				->whereBetween('seguimientos.estatus_id', [$input['estatus_f'], $input['estatus_t']])
				->whereBetween('seguimientos.created_at', [$input['fecha_f'], $input['fecha_t']])
				->orderBy('cli.empleado_id', 'seguimientos.estatus_id')
				->get();
		*/
		$seguimientos=Seguimiento::select('p.razon', DB::raw('concat(e.nombre," ", e.ape_paterno," ", e.ape_materno) as nombre'), 'sts.name', DB::raw('count(sts.name) as total'))
								->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
								->join('empleados as e', 'e.id', '=', 'c.empleado_id')
								->join('plantels as p', 'p.id', '=', 'c.plantel_id')
								->join('st_seguimientos as sts', 'sts.id', '=', 'seguimientos.st_seguimiento_id')
								->whereBetween('c.empleado_id', [$input['empleado_f'], $input['empleado_t']])
								->whereBetween('c.plantel_id', [$input['plantel_f'], $input['plantel_t']])
								->whereBetween('seguimientos.st_seguimiento_id', [$input['estatus_f'], $input['estatus_t']])
								->whereBetween('seguimientos.created_at', [$input['fecha_f'], $input['fecha_t']])
								->groupBy('p.razon', 'e.nombre', 'e.ape_paterno', 'e.ape_materno', 'sts.name')
								->get();
		//dd($seguimientos);
		
		//$s=Seguimiento::get();
		//dd($clientes);
			PDF::setOptions(['defaultFont' => 'arial']);
			$pdf = PDF::loadView('seguimientos.reportes.seguimientosXempleadoGr', array('seguimientos'=>$seguimientos, 'fecha'=>$fecha))
						->setPaper('letter', 'landscape');
			return $pdf->download('reporte.pdf');
			
			//return view('seguimientos.reportes.seguimientosXempleadoGr', array('seguimientos'=>$seguimientos, 'fecha'=>$fecha));	
			/*Excel::create('Laravel Excel', function($excel) use($seguimientos) {
				$excel->sheet('Productos', function($sheet) use($seguimientos) {
					$sheet->fromArray($seguimientos);
				});
			})->export('xls');
			*/
	}
}
