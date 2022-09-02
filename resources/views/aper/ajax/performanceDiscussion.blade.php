<div class="panel-group" id="exampleAccordionDefault" aria-multiselectable="true" role="tablist">
@if(count($discussions)>0)
@foreach($discussions as $discussion)
                  <div class="panel panel-info">
                    <div class="panel-heading" id="exampleHeadingDefaultThree{{$discussion->id}}" role="tab">
                      <a class="panel-title collapsed" data-toggle="collapse" href="#exampleCollapseDefaultThree{{$discussion->id}}" data-parent="#exampleAccordionDefault{{$discussion->id}}" aria-expanded="false" aria-controls="exampleCollapseDefaultThree{{$discussion->id}}">
                     {{$discussion->title}} @ {{$discussion->created_at->diffForHumans()}}
                    </a>
                    </div>
                  
               
                    <div class="panel-collapse collapse" id="exampleCollapseDefaultThree{{$discussion->id}}" aria-labelledby="exampleHeadingDefaultThree{{$discussion->id}}" role="tabpanel">
                      <div class="panel-body">
                       {!!  $discussion->discussion !!}
                      </div>

                    </div>
                   
                  </div>
                  
                @endforeach
                </div>
         @endif