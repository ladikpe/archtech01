<script>
    (function($){

        $(function(){


            $('[data-each]').each(function(){

                var fn = $(this).attr('data-each');

                if (window[fn]){
                    window[fn]($(this));
                }


            });



            $('[data-value]').each(function () {

                var vl = $(this).attr('data-value');

                if ($(this).is('[type=radio]')){

                    if ($(this).val() == vl){
                        $(this).prop('checked',true);
                        $(this).trigger('change');
                    }

                    return;
                }

                if ($(this).is('[type=checkbox]')){

                    if ($(this).val() == vl){
                        $(this).prop('checked',true);
                        $(this).trigger('change');
                    }

                    return;
                }

                $(this).val(vl);
                $(this).trigger('change');


            });




            @if (session()->has('modal'))

                var $modal = '{{ session()->get('modal') }}';
                $($modal).modal();

            @endif




        });


    })(jQuery);
</script>