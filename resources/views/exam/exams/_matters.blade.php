@foreach($mentionsList as $indexKey => $mention)
    @if($mentionsList->count() > 1)
    <h3 class="header smaller lighter blue">{{ $mention }}</h3>
    @endif

    <div style="columns: {{ $col }};">
    @foreach($matterParameters->where('id_mencion', $indexKey)->sortBy('MatterDescription') as $matter)
        <?php
        $reaCount = 0;
        $reaTotal = $matter->nro_reactivos_exam;
        ?>
        @foreach($exam->examsDetails as $det)
            @if($det->reagent->id_materia == $matter->id_materia and $det->estado == 'A' and $matter->nro_reactivos_exam > 0)
                <?php $reaCount++; ?>
            @endif
        @endforeach

        <?php
        $status = ( ($reaCount == 0) ? 'danger' : ( ($reaCount == $reaTotal) ? 'success': 'warning') );
        $icon = ( ($reaCount == 0) ? 'times' : ( ($reaCount == $reaTotal) ? 'check': 'exclamation') );
        ?>
        <ul class="nav nav-pills nav-stacked" style="padding: 0px; margin: 0px;">
            <li>
                <a class="{{ 'text-'.$status }}"
                   href="{{ route('exam.exams.detail', ['id_exam' => $exam->id, 'id_matter' => $matter->id_materia] ) }}"
                   style="padding: 0px;">
                    <i class="{{ 'fa fa-'.$icon.'-circle' }}" aria-hidden="true"></i>
                    {{ $matter->matter->descripcion.' ('.$reaCount.'/'.$reaTotal.')' }}
                </a>
                <hr style="margin: 5px 0 5px 0" />
            </li>
        </ul>
    @endforeach
    </div>
@endforeach