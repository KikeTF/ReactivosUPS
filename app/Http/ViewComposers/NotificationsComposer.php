<?php
/**
 * NOMBRE DEL ARCHIVO   NotificationsComposer.php
 *
 * TIPO                 ViewComposers
 *
 * DESCRIPCIÓN          Gestiona las notificaciones del usuario.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
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
                    $NotificationsDetail[] = [
                        'name' => 'Cambios de Contrase&ntilde;a', 
                        'count' => $passwordRecovery,
                        'route' => 'general.notifications.index',
                        'icon' => 'fa-key'
                    ];
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
                    $NotificationsDetail[] = [
                        'name' => 'Reactivos por Aprobar', 
                        'count' => $reagents,
                        'route' => 'reagent.approvals.index',
                        'icon' => 'fa-thumbs-o-up'];
                    $NotificationsCount = $NotificationsCount + $reagents;
                }

                $exams = ExamHeader::query()->where('id_estado', 3)->count();

                if ($exams > 0)
                {
                    $NotificationsDetail[] = [
                        'name' => 'Examenes por Revisar',
                        'count' => $exams,
                        'route' => 'exam.exams.index',
                        'icon' => 'fa-comment-o'
                    ];
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
                    $NotificationsDetail[] = [
                        'name' => 'Reactivos por Revisar',
                        'count' => $reagents,
                        'route' => 'reagent.reagents.index',
                        'icon' => 'fa-comment-o'
                    ];
                    $NotificationsCount = $NotificationsCount + $reagents;
                }
            }

            if ($aprExamen == 'S')
            {
                $exams = ExamHeader::query()->where('id_estado', 2)->count();
                $NotificationsDetail[] = [
                    'name' => 'Examenes por Aprobar', 
                    'count' => $exams,
                    'route' => 'exam.exams.index',
                    'icon' => 'fa-thumbs-o-up'];
                $NotificationsCount = $NotificationsCount + $exams;
            }

            if ($NotificationsCount > 0)
            {
                $notifications['count'] = $NotificationsCount;
                $notifications['detail'] = $NotificationsDetail;
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