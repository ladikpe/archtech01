{{--<li class="site-menu-item ">--}}

    {{--<a target="_blank" class="animsition-link" href="{{ route('app.get',['course-training']) }}?id={{ Auth::user()->id }}">--}}
        {{--<span class="site-menu-title">Access E - Learning</span>--}}
    {{--</a>--}}
{{--</li>--}}


{{--<li class="site-menu-item ">--}}

    {{--<a target="_blank" class="animsition-link" href="{{ route('app.get',['get-offline-training']) }}?id={{ Auth::user()->id }}">--}}
        {{--<span class="site-menu-title">Access Offline Training</span>--}}
    {{--</a>--}}
{{--</li>--}}

{{--@usercan(access_training)--}}
    <li class="site-menu-item ">
        <a  href="{{ route('training.get',['fetch-user-training']) }}">
            <span class="site-menu-title">My Trainings</span>
        </a>
    </li>
{{--@endusercan--}}

