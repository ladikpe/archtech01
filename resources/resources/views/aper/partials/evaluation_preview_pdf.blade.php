<style type="text/css">
    @charset "UTF-8";
    * {
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }

    html {
        font-size: 10px;
    }

    body {
        font-family: calibri, tahoma, arial, sans-serif;

        font-size: 14px;

        color: #555;
    }

    .wrap {
        width: 100%;
        max-width: 1000px;
        margin: 0 auto;
    }

    .intro {
        /*position: fixed;*/
        /*top: 0;*/
        left: 0;
        display: block;
        width: 100%;
        margin: 0 auto;

        font-size: 16px;
        font-size: 1.6rem;
        color: #34b7f0;
        text-align: center;
        background: white;
        -moz-box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.5);
        -webkit-box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.5);
        box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.5);
    }

    h3.table-title {
        color: #34b7f0;
        font-weight: normal;
        margin: 40px 0 0 10px;
        font-size: 32px;

    }

    .comparison-table {



        border-collapse: collapse;
        border: 1px solid #000;
        width:100%;

    }
    .comparison-table th {

    }

    .comparison-table th, .comparison-table td{
        border:1px solid #000;
        text-align: center;
    }
    .comparison-table th:first-child,.comparison-table td:first-child{
        text-align: left;
    }
    .pull-left{text-align: left;}

</style>
@php
    $fiscal_year=date('Y',strtotime($mp->from));
    $total=0;
   $obtainable=0;
@endphp

<div class="wrap">
    <center><img width="150" src="{{public_path('fermalogo.png')}}"></center>
    <br>
    <center>FEDERAL ROAD MAINTENANCE AGENCY</center>
    <p class="intro">Annual Performance Evaluation for {{$employee->name}} in {{$fiscal_year}}</p>
    <p> </p>

    @forelse($aper_metrics as $metric)
        <br>
        <br>
        <br>
        <h4>{{$metric->name}}</h4>
        <table class="comparison-table">
            <thead>
            <tr>
                <th style="text-align:left; padding-left: 10px;width: 45%;">Sub-Metric</th>
                <th>A</th>
                <th>B</th>
                <th >C</th>
                <th >D</th>
                <th >E</th>
            </tr>
            </thead>
            <tbody>
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
                        <td style="text-align: left;padding-left: 10px;width: 45%;">{{$sub_metric->name}}</td>
                        @for ($i = 5; $i >0; $i--)
                            <td>
                                @if($view=='report')
                                {{$i==$assessment->score?$assessment->score:''}}
                                @endif
                            </td>

                        @endfor

                    </tr>
                    @endif


                    @empty

                    @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <th style="text-align:left;padding-left: 10px;width: 45%;" colspan="6"> Sub Total: @if($view=='report'){{$subtotal}}@endif</th>
                    @php
                        $total+=$subtotal;
                    @endphp
                </tr>
                </tfoot>
        </table>
    @empty
    @endforelse

    <ul class="list-group list-group-gap">
        <li class="list-group-item bg-blue-grey-100">
            <i class="fa fa-check-circle" aria-hidden="true"></i> Obtainable: @if($view=='report'){{$obtainable}}@endif
        </li>
        <li class="list-group-item bg-blue-grey-100">
            <i class="fa fa-check-circle" aria-hidden="true"></i> Obtained: @if($view=='report'){{$total}}@endif
        </li>
        <li class="list-group-item bg-blue-grey-100">
            <i class="fa fa-check-circle" aria-hidden="true"></i> Overall Assessment: @if($view=='report'){{round(($total/$obtainable)*20,2)}}@endif
        </li>

    </ul>
</div>
