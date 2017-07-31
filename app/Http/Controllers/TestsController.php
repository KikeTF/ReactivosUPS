<?php

/**
 * NOMBRE DEL ARCHIVO   TestsController.php
 *
 * TIPO                 Controlador
 *
 * DESCRIPCIÓN          Gestiona las peticiones de información 
 *                      del simulador de examen complexivo.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\AnswerDetail;
use ReactivosUPS\AnswerHeader;
use ReactivosUPS\Campus;
use ReactivosUPS\CareerCampus;
use ReactivosUPS\ExamHeader;
use ReactivosUPS\ExamParameter;
use ReactivosUPS\Http\Requests;
use Log;
use ReactivosUPS\Mention;
use View;

class TestsController extends Controller
{
    
    public function __construct()
    {
        // Define el acceso solo para visitantes
        $this->middleware('guest');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('test.create')
            ->with('locationsList', $this->getLocations());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('test.create')
            ->with('locationsList', $this->getLocations());
    }

    /**
     * Muestra la pagina de instrucciones el Test.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function instruction($id)
    {
        $test = AnswerHeader::find($id);

        return view('test.instruction')
            ->with('test', $test);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = 0;
        $isNewTest = (bool)(isset($request['NewTest']) ? true : false);
        try
        {
            \DB::beginTransaction(); //Start transaction!

            // Si es un Test nuevo crea la cabecera y redirige a la pagina de instrucciones.
            // Caso contrario genera el detalle del Test de manera aleatorea y
            // redirige a la primera pregunta del Test.
            if ($isNewTest)
            {
                $id_campus = isset($request['id_campus']) ? $request['id_campus'] : 0;
                $id_carrera = isset($request['id_carrera']) ? $request['id_carrera'] : 0;

                $test = new AnswerHeader($request->all());

                $id_careerCampus = CareerCampus::query()
                    ->where('id_carrera', $id_carrera)
                    ->where('id_campus', $id_campus)
                    ->where('estado', 'A')
                    ->first()->id;

                $parameters = ExamParameter::query()
                    ->where('id_carrera_campus', $id_careerCampus)
                    ->where('estado', 'A')
                    ->orderBy('id', 'desc')->first();

                $test->id_mencion = ($request['id_mencion'] == '') ? '0' : $request['id_mencion'];
                $test->id_examen_cab = $parameters->id_examen_test;
                $test->id_parametro = $parameters->id;
                $test->fecha_inicio = date('Y-m-d H:i:s');
                $test->estado = 'A';
                $test->creado_por = 0;
                $test->fecha_creacion = date('Y-m-d H:i:s');
                $test->save();

                $id = $test->id;
            }
            else
            {
                $id = isset($request['id']) ? $request['id'] : 0;
                $test = AnswerHeader::find($id);
                $id_mencion_comun = (int)Mention::query()->where('cod_mencion', 'COMUN-'.$test->examHeader->careerCampus->id_carrera)->first()->id;

                $ExamDet = ExamHeader::find($test->parameter->id_examen_test)
                    ->examsDetails()->orderByRaw("RAND()")->get();//->pluck('id')->toArray();

                foreach ($ExamDet as $exDet)
                {
                    $idMenc = $exDet->reagent->distributive->mattercareer->id_mencion;
                    if ($idMenc == $test->id_mencion || $idMenc == $id_mencion_comun)
                    {
                        $det["id_examen_det"] = $exDet->id;
                        $det["creado_por"] = 0;
                        $det["fecha_creacion"] = date('Y-m-d H:i:s');
                        $testDet[] = new AnswerDetail($det);
                    }
                }

                if ( isset($testDet) )
                {
                    $test->fecha_inicio = date('Y-m-d H:i:s');
                    $test->save();
                    $test->answersDetails()->saveMany($testDet);

                    $id = $test->answersDetails->first()->id;
                }
                else
                {
                    flash("No se pudo procesar la solicitud", 'danger')->important();
                    return redirect()->route('test.index');
                }
            }
        }
        catch(\Exception $ex)
        {
            \DB::rollback();
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[TestsController][store] Request: ".implode(',', $request->all())."; Exception: ".$ex);
            return redirect()->route('test.index');
        }
        finally
        {
            \DB::commit();
        }

        if ($isNewTest)
            return redirect()->route('test.instruction', $id);
        else
            return redirect()->route('test.question', $id);
    }

    /**
     * Muestra la pregunta seleccionada.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function question($id)
    {
        try
        {
            $question = AnswerDetail::find($id);
            $test = AnswerHeader::find($question->id_resultado_cab);

            // Calcula el tiempo transcurrido desde el inicio del examen
            $limitTime = (float)$test->parameter->duracion_examen;
            $startTime = strtotime($test->fecha_inicio);
            $currentTime = strtotime(date('Y-m-d H:i:s'));
            $time = round(($currentTime - $startTime)/60, 2);

            // Si el examen no esta activo o el tiempo esta expirado
            // redirecciona a la pagina de inicio de los Test
            if($test->estado != 'A' || $time > $limitTime)
                return redirect()->route('test.index');

            $reagent = $question->examDetail->reagent;

            return view('test.question')
                ->with('test', $test)
                ->with('question', $question)
                ->with('reagent', $reagent);
        }
        catch (\Exception $ex)
        {
            flash("Problemas al cargar la pagina. Consulte el administrador.", 'danger')->important();
            Log::error("[TestsController][question] id: ".$id);
            return redirect()->route('test.index');
        }
    }

    /**
     * Funcionalidad no requerida.
     * Redirecciona a la pagina de inicio del Test.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('test.index');
    }

    /**
     * Funcionalidad no requerida.
     * Redirecciona a la pagina de inicio del Test.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect()->route('test.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try
        {
            $id_nextQuestion = isset($request['id_nextQuestion']) ? (int)$request['id_nextQuestion'] : 0;
            $id_opcion_resp = isset($request['id_opcion_resp']) ? (int)$request['id_opcion_resp'] : 0;
            $question = AnswerDetail::find($id);

            \DB::beginTransaction(); //Start transaction!

            if ( $id_opcion_resp > 0 )
            {
                $question->id_opcion_resp = $id_opcion_resp;
                $question->resp_correcta = ($question->examDetail->reagent->id_opcion_correcta == $id_opcion_resp) ? 'S' : 'N';
                $question->estado = 'A';
            }
            else
            {
                $question->id_opcion_resp = 0;
                $question->resp_correcta = 'N';
                $question->estado = 'P';
            }
            $question->save();

            if ( $id_nextQuestion == 0 )
            {
                $reactivos_acertados = $question->answerHeader->answersDetails()->where('resp_correcta', 'S')->count();
                $reactivos_errados = $question->answerHeader->answersDetails()->where('resp_correcta', 'N')->count();
                $puntaje = round(100*$reactivos_acertados/$question->count());
                $estado = (isset($request['estado']) && ($request['estado'] == 'E')) ? "E" : (($puntaje >= 70) ? "P" : "R");
                
                $question->answerHeader->estado = $estado;
                $question->answerHeader->reactivos_acertados = $reactivos_acertados;
                $question->answerHeader->reactivos_errados = $reactivos_errados;
                $question->answerHeader->modificado_por = 0;
                $question->answerHeader->fecha_modificacion = date('Y-m-d H:i:s');
                $question->answerHeader->fecha_fin = date('Y-m-d H:i:s');
                $question->answerHeader->save();
            }

        }
        catch(\Exception $ex)
        {
            \DB::rollback();
            flash("No se pudo procesar la respuesta!", 'danger')->important();
            Log::error("[TestsController][update] id: ".$id);
            return redirect()->route('test.index');
        }
        finally
        {
            \DB::commit();
        }

        if ( $id_nextQuestion > 0 )
            return redirect()->route('test.question', $id_nextQuestion);
        else
            return redirect()->route('test.result', $question->answerHeader->id);
    }

    /**
     * Muestra los resultados del Test.
     * Si han pasado mas de 10 minutos redirecciona a la pagina de inicio del Test.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function result($id)
    {
        try
        {
            $test = AnswerHeader::find($id);

            $endTime = strtotime($test->fecha_fin);
            $currentTime = strtotime(date('Y-m-d H:i:s'));
            $time = round(($currentTime - $endTime)/60, 2);

            if( $time > 10 )
                return redirect()->route('test.index');

            return view('test.result')
                ->with('test', $test);
        }
        catch (\Exception $ex)
        {
            flash("Problemas al cargar la pagina. Consulte el administrador.", 'danger')->important();
            Log::error("[TestsController][result] id: ".$id."; Exception: ".$ex);
            return redirect()->route('test.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            \DB::beginTransaction(); //Start transaction!

            $test = AnswerHeader::find($id);

            // Si el estado del test es distinto de Aprobado (P) o Reprobado (R)
            // el test se da de baja y entra en estado Cancelado (C)
            if($test->estado != 'P' && $test->estado != 'R')
            {
                $test->estado = 'C';
                $test->fecha_fin = date('Y-m-d H:i:s');
                //$test->answersDetails()->delete();
            }

            $test->modificado_por = 0;
            $test->fecha_modificacion = date('Y-m-d H:i:s');
            $test->save();
        }
        catch(\Exception $ex)
        {
            \DB::rollback();
            flash("No se pudo procesar la transaccion!", 'danger')->important();
            Log::error("[TestsController][update] id: ".$id."; Exception: ".$ex);
            return redirect()->route('test.index');
        }
        finally
        {
            \DB::commit();
        }

        return redirect()->route('test.index');
    }

    /**
     * Obtiene listado de informacion requerida y retorna el codigo html en vista parciales.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getLists(Request $request)
    {
        try
        {
            // Obtiene parametros del enviados desde la vista en el $request
            $lista = (isset($request['lista']) ? $request->lista : "");
            $id_sede = (isset($request['id_sede']) ? (int)$request->id_sede : 0);
            $id_campus = (isset($request['id_campus']) ? (int)$request->id_campus : 0);
            $id_carrera = (isset($request['id_carrera']) ? (int)$request->id_carrera : 0);
            $id_mencion = (isset($request['id_mencion']) ? (int)$request->id_mencion : 0);

            /**
             * Determina el tipo de lista requerida ($lista) y realiza los siguientes pasos:
             *  1.- Define la ruta de la vista parcial a la cual se retorna la lista ($route)
             *  2.- Obtiene la lista da datos a retornar ($...List)
             *  3.- Genera el codigo html a retornar ($html)
             *
             * En caso de no determinar el tipo de lista o algun error, retorna lista vacia
             */
            if ($lista == "campus")
            {
                $route = 'shared.optionlists._campuslist';

                $campusList = Campus::query()
                    ->where('id_sede', $id_sede)
                    ->where('estado','A')
                    ->orderBy('descripcion', 'asc')
                    ->lists('descripcion','id');

                $html = View::make($route)
                    ->with('campusList', $campusList)
                    ->render();
            }
            elseif ($lista == "carrera")
            {
                $route = 'shared.optionlists._careerslist';

                $careersList = CareerCampus::query()
                    ->where('estado','A')
                    ->where('id_campus', $id_campus)
                    ->get()->pluck('career')
                    ->sortBy('descripcion')
                    ->lists('descripcion','id');

                $html = View::make($route)
                    ->with('careersList', $careersList)
                    ->with('careerFilter', null)
                    ->render();

            }
            elseif ($lista == "mencion")
            {
                $route = 'shared.optionlists._mentionslist';

                $mentionsList = Mention::query()
                    ->where('id_carrera', $id_carrera)
                    ->where('cod_mencion', '!=', 'COMUN-'.$id_carrera)
                    ->where('estado', 'A')
                    ->lists('descripcion','id');

                if($mentionsList->count() > 0)
                    $html = View::make($route)
                        ->with('mentionsList', $mentionsList)
                        ->with('mentionFilter', $id_mencion)
                        ->render();
                else
                    $html = View::make($route)->render();
            }

        }
        catch (\Exception $ex)
        {
            Log::error("[TestsController][getList] Exception: " . $ex);
            if (isset($route))
                $html = View::make($route)->render();
            else
                $html = '<select></select>';
        }

        return \Response::json(['html' => $html]);
    }
}
