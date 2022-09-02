<template>
                
    <!-- start -->
  <span>
      <span>
          {{ display() }}
      </span>
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
               loading:false
           }
        },
        mounted() {
            // console.log('Component mounted KPI .');
            // this.reload2();

            this.$root.$on('trigger-values',()=>{
                // this.reload2();
            });
        },
        props:['field','data1'],
        watch:{
           api(n,o){
            //  alert('Triggered ...');
           }
        },
        methods:{

            display(){
                if (typeof(this.data1.user_selection) != 'undefined'){
                   return this.isset(this.data1.user_selection.data)?  ( this.data1.user_selection.data != null? this.data1.user_selection.data[this.field] : '_' ) : '_';
                }else{
                   return '_';    
                }
            },

            isset(varId){
                console.log(typeof(varId));
              return typeof(varId) != 'undefined';
            },

            reload2(){
                this.loading = true;
                //http://127.0.0.1:8000/api/kpi-get-user-value-organization/2/15/172
                //interval,group_id,user_id
                // console.log(this.api + this.kpiFrequencyInterval.id + '/' + this.kpiGroup.id + '/' + this.user_id);
                this.doGet(this.api + this.kpiFrequencyInterval.id + '/' + this.kpiGroup.id + '/' + this.user_id)
                .then(res=>{
                    this.loading = false;
                    if (res.data == null){
                      this.value = '_';    
                    }else{
                      this.value = res.data[this.field];  
                    }
                   console.log(res);    
                });
            }

        }
    }
</script>
