<?php
/**
 * Created by PhpStorm.
 * User: Neptali Torres F
 * Date: 30/12/2016
 * Time: 2:19
 */

namespace ReactivosUPS\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use ReactivosUPS\ExamHeader;
use ReactivosUPS\Http\Controllers\Controller;
use Log;
use ReactivosUPS\MatterCareer;
use ReactivosUPS\Notification;
use ReactivosUPS\Reagent;

class NotificationsComposer extends Controller
{
    public function compose(View $view)
    {
        try
        {
            $id_Sede = (int)\Session::get('idSede');
            $ids_carreras = \Session::get('idsCarreras');
            $ids_areas = \Session::get('idsJefeAreas');
            $aprReactivo = \Session::get('ApruebaReactivo');
            $aprExamen = \Session::get('ApruebaExamen');

            $NotificationsCount = 0;


            if (\Session::get('RestablecePassword') == 'S')
            {
                $passwordRecovery = Notification::query()
                    ->where('tipo', 'PWD')->where('estado', 'A')->count();

                if ($passwordRecovery > 0)
                {
                    $NotificationsDetail[] = ['Name' => 'Cambios de Contrase&ntilde;a', 'Count' => $passwordRecovery];
                    $NotificationsCount = $NotificationsCount + $passwordRecovery;
                }
            }

            if ($aprReactivo == 'S')
            {
                $mattersCareers = MatterCareer::with('careerCampus')
                    ->whereHas('careerCampus', function($query) use($ids_carreras){
                        if (sizeof($ids_carreras) > 0) $query->whereIn('id_carrera', $ids_carreras);
                    });

                $mattersCareers = $mattersCareers->whereIn('id_area', $ids_areas);
                $ids_materias_carreras = $mattersCareers->get()->pluck('id')->toArray();

                $reagents = Reagent::with('distributive')
                    ->where('id_estado', 2)
                    ->whereHas('distributive', function($query) use($id_Sede, $ids_carreras, $ids_materias_carreras, $ids_areas){
                        $query->where('id_Sede', $id_Sede);
                        if (sizeof($ids_carreras) > 0) $query->whereIn('id_carrera', $ids_carreras);
                        if (sizeof($ids_areas) > 0) $query->whereIn('id_materia_carrera', $ids_materias_carreras);
                    })->count();

                if ($reagents > 0)
                {
                    $NotificationsDetail[] = ['Name' => 'Reactivos por Aprobar', 'Count' => $reagents];
                    $NotificationsCount = $NotificationsCount + $reagents;
                }

                $exams = ExamHeader::query()->where('id_estado', 3)->count();

                if ($exams > 0)
                {
                    $NotificationsDetail[] = ['Name' => 'Examenes por Revisar', 'Count' => $exams];
                    $NotificationsCount = $NotificationsCount + $exams;
                }
            }
            else
            {
                $reagents = Reagent::with('distributive')
                    ->where('id_estado', 4)
                    ->where('creado_por', \Auth::id())
                    ->whereHas('distributive', function($query) use($id_Sede, $ids_carreras){
                        $query->where('id_Sede', $id_Sede);
                        if (sizeof($ids_carreras) > 0) $query->whereIn('id_carrera', $ids_carreras);
                    })->count();

                if ($reagents > 0)
                {
                    $NotificationsDetail[] = ['Name' => 'Reactivos por Revisar', 'Count' => $reagents];
                    $NotificationsCount = $NotificationsCount + $reagents;
                }
            }

            if ($aprExamen == 'S')
            {
                $exams = ExamHeader::query()->where('id_estado', 2)->count();
                $NotificationsDetail[] = ['Name' => 'Examenes por Aprobar', 'Count' => $exams];
                $NotificationsCount = $NotificationsCount + $exams;
            }

            if ($NotificationsCount > 0)
            {
                $notifications['Count'] = $NotificationsCount;
                $notifications['Detail'] = $NotificationsDetail;
            }

            //dd($notifications);

            if (isset($notifications))
                $view->with('notifications', $notifications);
            
        }
        catch (\Exception $ex)
        {
            Log::error("[NotificationsComposer][compose] Exception: ".$ex);
        }
    }
}