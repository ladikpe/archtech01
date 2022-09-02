<table>
    <thead>
    <tr><th>Type</th>
        <th>Causer</th>
        <th>Old</th>
        <th>New</th>
        <th>Description</th>
        <th>Created On</th>
        </tr>
    </thead>
    <tbody>
    @foreach($activities as $activity)
        <tr>
        <td>{{$activity->subject_type}}</td>
        <td>{{$activity->causer->name}}</td>
        <td>{{$activity->description=='updated'?$activity->changes['old']:''}}</td>
            <td>{{($activity->changes['attributes']}}</td>
            <td>{{$activity->description}}</td>
        <td>{{date("m/d/Y", strtotime($activity->created_at))}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
