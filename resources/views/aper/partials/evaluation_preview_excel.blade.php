
@php
    $fiscal_year=date('Y',strtotime($mp->from));
    $total=0;
   $obtainable=0;
@endphp
<table>
    <thead>
    <tr>
        <td colspan="14" style="font-size: 24px;">FEDERAL ROAD MAINTENANCE AGENCY</td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="14" style="font-size: 18px;">Annual Performance Evaluation for {{$employee->name}} in {{$fiscal_year}}</td>
    </tr>
    @forelse($aper_metrics as $metric)
        <tr>
            <td colspan="14">{{$metric->name}}</td>
        </tr>
        <tr></tr>
        <tr>
            <th >Sub-Metric</th>
            <th>A</th>
            <th>B</th>
            <th >C</th>
            <th >D</th>
            <th >E</th>
        </tr>
        @php
            $subtotal=0;
        @endphp
        @forelse($metric->sub_metrics as $sub_metric)
            @if(($sub_metric->editable==1 and $sub_metric->user_id==$employee->id)||$sub_metric->editable==0)
                @php
                    $assessment=$evaluations[$metric->id][$sub_metric->id]['assessment_detail'];
                $subtotal+=$assessment->score;
                 $obtainable+=5

                @endphp
                <tr>
                    <td >{{$sub_metric->name}}</td>
                    @for ($i = 5; $i >0; $i--)
                        <td>

                                {{$i==$assessment->score?$assessment->score:''}}

                        </td>

                    @endfor

                </tr>
            @endif


        @empty

        @endforelse
        <tr>
            <th  colspan="6"> Sub Total: {{$subtotal}}</th>
            @php
                $total+=$subtotal;
            @endphp
        </tr>
        <tr></tr>
        @empty
    @endforelse
    <tr></tr>
    <tr></tr>
    <tr>
        <td>Obtainable:</td>
        <td>{{$obtainable}}</td>
    </tr>
    <tr>
        <td>Obtained:</td>
        <td>{{$total}}</td>
    </tr>
    <tr>
        <td> Overall Assessment:</td>
        <td>{{round(($total/$obtainable)*20,2)}}</td>
    </tr>

    </tbody>
</table>


