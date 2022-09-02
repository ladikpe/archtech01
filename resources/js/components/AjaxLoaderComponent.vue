<template>

  <div :style="'display: inline-block;' + styleString" v-show="data.ajaxBalance > 0">
      Loading 
      <img src="https://upload.wikimedia.org/wikipedia/commons/c/c7/Loading_2.gif" alt="" style="width: 11%;display: inline-block;" />
  </div>

</template>

<script>

export default {
        props:['styleString'],
        data(){
           return {
              data:{
                  name:'Ajax-loader.',
                  version:'1.0.0',
                  loading:false,
                  ajaxBalance:0
              }
           };
        },
        mounted(){

            console.log('Component mounted.');

            this.$root.$on('ajax-start',()=>{
               this.data.loading = true;
               ++this.data.ajaxBalance;
            //    alert('start');
            });

            this.$root.$on('ajax-stop',()=>{
               this.data.loading = false;
               --this.data.ajaxBalance;

            //    alert('stop');
            });

            // this.doFetch();
        }


    }
</script>

<style scoped>
   
</style>
