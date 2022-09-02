          <script>
    (function($){

        $.fn.selectData = function(settings){
            settings = $.extend({
                url:'url',
                key:'id',
                label:'name'
            },settings);
            var $this = this;

            fetch(settings.url,{
                method:'GET'
            }).then((res)=>res.json()).then((res)=>{
                if (res.list){
                    res.list.forEach(function(v,k){
                        $this.append(`<option value="${v[settings.key]}">${v[settings.label]}</option>`);
                    });
                }
            });
        };

        $.fn.useTemplate = function(){

            var html = this.html();

            return {

                mount:function(sel){
                    var $el = $(sel);
                    $el.html(html);
                    return $el;
                }

            };

        };

        $.fn.crudTable = function(settings){

            var $obj = this.get(0);

            // if ($obj.bound)return;




            /**
             * Settings config
             *
             * tableSelector
             * createModalFormButtonSelector
             * createModalFormSelector
             * editModalFormSelector
             * fetchUrl
             * createUrl
             * updateUrl
             * deleteUrl
             *
             * ---Events----
             * onSelectRow
             * --Mutators----
             * onAppendRow
             *
             */

            settings = $.extend({
                //  tableSelector:'table',
                //  createModalFormButtonSelector:'#create-modal-button',
                createModalFormSelector:'#create-modal',
                editModalFormSelector:'#edit-modal',
                fetchUrl:function(){return 'fetch-url';},
                createUrl:function(){return 'create-url';},
                updateUrl:function(data){return 'update-url';},
                deleteUrl:function(data){return 'delete-url';},
                onSelectRow:function($el,data){},
                onAppendRow:function($el,data){},
                onFillForm:function($el,data){},
                onAjaxFinished:function(){},
                headers:{
                    "X-CSRF-TOKEN": '{{ csrf_token() }}',
                    "Content-Type": "application/json"
                }
            },settings);

            var $tableSelector = this.find('table');   //$(settings.tableSelector);
            var $createFormButtonSelector =  this.find('[data-create-form]'); //$(settings.createModalFormButtonSelector);
            var $createModalFormSelector = $(settings.createModalFormSelector);
            var $editModalFormSelector = $(settings.editModalFormSelector);

            // if ($obj.bound){
            //     return;
            // }



            var $tableSlot = $tableSelector.html();
            $tableSelector.html('');

            $createFormButtonSelector.on('click',function(){
                $createModalFormSelector.modal();
            });

            var $createForm = $createModalFormSelector.find('form');

            $createForm.off('submit');
            $createForm.on('submit',function(){

                var data = getFormData($(this));
                //    data._method = 'PUT';

                fetch(settings.createUrl(),{
                    method:'POST',
                    headers:settings.headers,
                    body:JSON.stringify(data)
                }).then((res)=>res.json()).then((res)=>{

                    if (res.error){
                        toastr.error(res.message);
                        return;
                    }

                    closeCreateModal();
                    toastr.success(res.message);
                    renderTable();

                });

                return false;
            });

            function renderTable(){
                fetch(settings.fetchUrl(),{
                    method:'GET',
                    headers:settings.headers
                }).then((res)=>res.json()).then((res)=>{

                    $tableSelector.html('');
                    $tableSelector.append($tableSlot);

                    if (res.list){
                        res.list.forEach(function(v,k){
                            var $el = $(settings.onAppendRow(v));
                            var data = v;
                            settings.onSelectRow($el,data,function(){ //show edit form
                                fillUpEditForm(data);
                                $editModalFormSelector.modal();
                            },function(){ //remove record
                                removeRecord(data);
                            });
                            $tableSelector.append($el);
                        });
                    }

                    settings.onAjaxFinished();

                });
            }

            function removeRecord(data){
                toastr.info('Removing ... ');
                fetch(settings.deleteUrl(data),{
                    method:'POST',
                    body:JSON.stringify({
                        _method:'DELETE'
                    }),
                    headers:settings.headers
                }).then((res)=>res.json()).then((res)=>{
                   if (res.error){
                       toastr.error(res.message);
                       return;
                   }
                    toastr.success(res.message);
                    renderTable();
                });
            }

            function getFormData($el){
                var data = {};
                data._token = '{{ csrf_token() }}';
                $el.find('[data-input]').each(function(){

                    if ($(this).is('[type=checkbox]') || $(this).is('[type=radio]')){

                        if ($(this).is(':checked')){
                            data[$(this).attr('name')] = $(this).val();
                        }
                        return;
                    }

                    data[$(this).attr('name')] = $(this).val();
                });
                console.log('form-data',data);
                return data;
            }

            function closeEditModal(){
                $editModalFormSelector.find('[data-dismiss]').trigger('click');
            }

            function closeCreateModal(){
                $createModalFormSelector.find('[data-dismiss]').trigger('click');
            }

            function fillUpEditForm(data){

                for (var i in data){
                    (function($i,$data){

                        var $el = $editModalFormSelector.find('[name=' + $i + ']');
                        // console.log($el);
                        $el.val($data);
                        // console.log($data,$i,$el,$el.is('[type=checkbox]'));
                        if (($el.is('[type=checkbox]') || $el.is('[type=radio]'))){
                            $el.prop('checked',false);
                            // console.log(data[i],i,$el);
                            $el.val(1);
                            if ($data*1 == 1){
                                $el.prop('checked',true);
                                // console.log('checked',$el);
                            }
                        }

                        if ($el.is('select')){
                           $el.trigger('change');
                        }

                    })(i,data[i]);

                }

                settings.onFillForm($editModalFormSelector,data);


                var $updateForm = $editModalFormSelector.find('form');
                $updateForm.off('submit');
                $updateForm.on('submit',function(){

                    var data_ = getFormData($(this));
                    data_._method = 'PUT';

                    toastr.info('Saving ... ');

                    fetch(settings.updateUrl(data),{
                        method:'POST',
                        headers:settings.headers,
                        body:JSON.stringify(data_)
                    }).then((res)=>res.json()).then((res)=>{

                        if (res.error){
                            toastr.error(res.message);
                            return;
                        }

                        closeEditModal();
                        toastr.success(res.message);
                        renderTable();

                    });

                    return false;
                });

                // $editModalFormSelector.find();

            }






            renderTable();


            return {
              setFetchUrl:function(url){

                  settings.fetchUrl = function(){
                    return url;
                  };

                  renderTable();
              },
              refresh:function(){
                  renderTable();
              }
            };

        };




    })(jQuery);
</script>