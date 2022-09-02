<div id="setting-container" class="modal fade" role="dialog">
    <div class="modal-dialog modal-info">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Manage Training Settings</h4>
            </div>
            <div class="modal-body">


                {{--content--}}
                <div class="col-sm-12" style="background-color: #fff;">

                    <div class="col-md-12" align="right">

                        <button style="margin-bottom: 11px;" type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#setting">Add Setting</button>

                    </div>

                    <table class="table table-striped" style="border: 1px solid #eee;">
                        <tr>
                            <th>
                                Name
                            </th>
                            <th>
                                Content
                            </th>
                            <th>
                                Actions
                            </th>
                        </tr>
                        @foreach ($list as $item)
                            <tr>
                                <td>
                                    {{ $item->name }}
                                </td>
                                <td>
                                    {{ $item->content }}
                                </td>
                                <td>

                                    <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#setting{{ $item->id }}">Edit </a>
                                    <a onclick="return confirm('Do you want to confirm this action?')" href="{{ route('call.service',['tr_training_settings:removeSetting']) }}?key={{ $item->name }}" class="btn btn-sm btn-danger">Remove</a>

                                </td>
                            </tr>
                        @endforeach
                    </table>


                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div>

    </div>
</div>







@include('ferma_training.settings.create')


@foreach ($list as $item)

    @include('ferma_training.settings.edit')

@endforeach
