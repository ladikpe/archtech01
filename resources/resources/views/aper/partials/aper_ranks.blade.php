@foreach($ranks as $rank)
                                  <a class="list-group-item grey-600" href="javascript:void(0)" onclick="getStaff({{$rank->id}},'{{$rank->name}}');">
                                  <i class="icon md-inbox" aria-hidden="true"></i> {{$rank->name}}
                                </a>
                                    @endforeach