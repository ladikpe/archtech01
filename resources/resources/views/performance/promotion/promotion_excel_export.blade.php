@foreach($ranks as $rank)
    <table>
        <thead>
        <tr>
            <th colspan="3">{{ $rank->name }}</th>
        </tr>
        <tr>
            <th>Staff ID</th>
            <th>Name</th>
            <th>Exam Score</th>
        </tr>
        </thead>
        <tbody  id="directempsbody">
        @forelse($rank->current_rank_promotion as $promotion)
            <tr>
                <td>{{$promotion->user->emp_num}}</td>
                <td>{{$promotion->user->name}}</td>
                <td>{{$promotion->exam_score}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="8" style="text-align: center">
                    <h3 style="">No Pending Promotions for this year.</h3>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endforeach