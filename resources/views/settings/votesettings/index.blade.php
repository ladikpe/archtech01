  <div class="page-header">
      <h1 class="page-title">{{__('All Settings')}}</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}">{{__('Home')}}</a></li>
        <li class="breadcrumb-item ">{{__('AWARD and Vote Settings')}}</li>
        <!--<li class="breadcrumb-item active">{{__('You are Here')}}</li>-->
      </ol>
      <div class="page-header-actions">
        <div class="row no-space w-250 hidden-sm-down">

          <div class="col-sm-6 col-xs-12">
            <div class="counter">
              <span class="counter-number font-weight-medium">{{date('Y-m-d')}}</span>

            </div>
          </div>
          <div class="col-sm-6 col-xs-12">
            <div class="counter">
              <span class="counter-number font-weight-medium" id="time"></span>
            </div>
          </div>
        </div>
      </div>
  </div>
      




<!-- PAGE PART 0 AWARDS LIST-->
<div id="awardsyear">
</div>

<!-- PAGE PART 1 AWARDS LIST-->
<div id="awards">
</div>

<!-- PAGE PART 2 ATTRIBUTE LIST-->
<div id="attributes">
</div>

<!-- PAGE PART 2 ATTRIBUTE LIST-->
<div id="configurations">
</div>




<script>
  $("#awardsyear").load("{{ route('awardsyear') }}");
  $("#awards").load("{{ route('awards') }}");
  $("#attributes").load("{{ route('attributes') }}");
  $("#configurations").load("{{ route('configurations') }}");



  function filterAttribute(url,data,id_ref){
    $.get(url,data,function(data){
        $(`#${id_ref}`).html(data);
    })
  }








  var listeners = {};
  function attach(tag,cb){
   listeners[tag] = listeners[tag] || [];
   listeners[tag].push(cb);
 }

 function notify(tag,data){
  if (listeners[tag]){
    listeners[tag].forEach(function(v,k){
      v(data);
    });
  }
}

function linkDropDowns($first,$second){
     var $awardcategory = $('#' + $first); //'#awardcategory'
     var $awardtype = $('#' + $second); //'#awardtype'

     attach('award-changed',function(data){
      data = data.toLowerCase();

      if (data.split(' ').indexOf('department') != -1 || data.split(' ').indexOf('unit') != -1 || data.split(' ').indexOf('zone of') != -1 || data.split(' ').indexOf('office') != -1){
       $awardtype.val(2);
     }else{
       $awardtype.val(1);
     }

   }); 

     $awardcategory.on('change',function(){
      // alert('okkkk');
      //option:selected").text()
      notify('award-changed',$('#' + $first + ' option:selected').text());
    });

   }
</script>



