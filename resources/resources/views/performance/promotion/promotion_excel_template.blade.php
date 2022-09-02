<table>
    <thead>
    <tr>
        <th>Staff ID</th>
        <th>Name</th>
        <th>Profession Exam Score</th>
        <th>Civil Service Exam Score</th>
        <th>General Paper Exam Score</th>
        <th>Exam No</th>
    </tr>
    </thead>
    <tbody  id="directempsbody">
    @forelse($promotions as $promotion)
        <tr>
            <td>{{$promotion->user->emp_num}}</td>
            <td>{{$promotion->user->name}}</td>
            <td>{{$promotion->profession_exam_score}}</td>
            <td>{{$promotion->civil_service_exam_score}}</td>
            <td>{{$promotion->general_paper_exam_score}}</td>
            <td>{{$promotion->exam_number}}</td>
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