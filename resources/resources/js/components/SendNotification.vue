<template>
                
    <!-- start -->
  <span>

     <div class="col-xs-12">

          <h4 style="text-decoration: underline;color: #0e84b4;font-weight: bold;">
              Send KPI Notification
          </h4>

          <form method="POST" @submit.prevent="sendNotification">
            
            <div class="col-xs-12">
                   <label for="" style="
    font-weight: bold;
    font-size: 15px;
">
                       Subject
                   </label>
            </div>         
            <div class="col-xs-12">
              <input v-model="input.subject" type="text" class="form-control" placeholder="Subject" style="border: 1px solid #62a8ea;" />
            </div>     


            <div class="col-xs-12">
                   <label for="" style="
    font-weight: bold;
    font-size: 15px;
">
                       Message
                   </label>
            </div>         
            <div class="col-xs-12">
              <textarea v-model="input.message" style="border: 1px solid #62a8ea;" class="form-control" placeholder="Message"></textarea>
            </div>     



            <div class="col-xs-12">
                   <label for="" style="
    font-weight: bold;
    font-size: 15px;
">&nbsp;</label>
            </div>         
            <div class="col-xs-12">
              <input type="submit" class="btn btn-sm btn-success" value="Send" />
            </div>

          </form>  

     </div>

  </span>
    <!-- end -->

</template>
<script>
// https://www.seeedstudio.site/static/frontend/bs_complex/bs_complex5/en_US/images/loading.gif
//https://upload.wikimedia.org/wikipedia/commons/c/c7/Loading_2.gif

    export default {
        data(){
           return {
               value:'_',
               loading:false,
               input:{
                   message:'',
                   subject:''
               }
           }
        },
        mounted() {
            // console.log('Component mounted KPI .');
            // this.reload2();
            // this.$root.$on('trigger-values',()=>{
            //     // this.reload2();
            // });
        },
        methods:{
           sendNotification(){
            
            this.startAjax();
            fetch(
                '/api/send-global-notification',//data.group_id,
                {
                method: "POST",
                body: JSON.stringify({
                    subject: this.input.subject,
                    message: this.input.message, //data.group_id,
                    _token: laravel.csrfToken
                }),
                headers: { "content-Type":"application/json" }
                }
                )
                .then(res => res.json())
                .then(res => {
                this.stopAjax();
                // this.$modal.hide("rate-yourself");
                toastr.info(res.message); //'KPI-Department Saved.'
                
                this.input.subject = '';
                this.input.message = '';
                // this.getKpiDepartments();
                // this.loading = 0;
                }).catch((error)=>{
                    console.log(error);
                });

           }
        }
    }
</script>
