@foreach($mattersList as $matter)
    <?php
    $matterCount = 0;
    $matterTotal = $matterParameters->where('id_materia', $matter->id)->first()->nro_reactivos_exam;
    ?>
    @foreach($exam->examsDetails as $det)
        @if(\ReactivosUPS\ExamDetail::find($det->id)->reagent->id_materia == $matter->id)
            <?php $matterCount++; ?>
        @endif
    @endforeach

    <?php
    $status = ( ($matterCount == 0) ? 'danger' : ( ($matterCount == $matterTotal) ? 'success': 'warning') );
    $icon = ( ($matterCount == 0) ? 'times' : ( ($matterCount == $matterTotal) ? 'check': 'exclamation') );
    ?>
    <ul class="nav nav-pills nav-stacked" style="padding: 0px; margin: 0px;">
        <li>
            <a class="{{ 'text-'.$status }}"
               href="{{ route('exam.exams.detail', ['id_exam' => $exam->id, 'id_matter' => $matter->id] ) }}"
               style="padding: 0px;">
                <i class="{{ 'fa fa-'.$icon.'-circle' }}" aria-hidden="true"></i>
                {{ $matter->descripcion.' ('.$matterCount.'/'.$matterTotal.')' }}
            </a>
            <hr style="margin: 5px 0 5px 0" />
        </li>
    </ul>
@endforeach