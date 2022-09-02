@usercan(upload_training_plan)
<li class="site-menu-item ">
    <a class="animsition-link" href="{{ route('training.get',['fetch-training-plan']) }}?{{ uniqid() }}">
        <span class="site-menu-title">Upload Training Plans</span>
    </a>
</li>
@endusercan

@usercan(upload_training_plan)
<li class="site-menu-item ">
    <a class="animsition-link" href="{{ route('training.get',['fetch-training-plan-approvals']) }}">
        <span class="site-menu-title">Approve Training Plans</span>
    </a>
</li>
@endusercan



@usercan(upload_training_plan)
<li class="site-menu-item ">
    <a class="animsition-link" href="{{ route('man_power_training.index') }}">
        <span class="site-menu-title">Man Power Development</span>
    </a>
</li>
@endusercan

