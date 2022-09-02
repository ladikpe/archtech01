<template>
  <!-- start -->
  <span></span>
  <!-- end  -->
</template>
<script>
import { setTimeout } from 'timers';
export default {
  
   mounted(){
     setTimeout(()=>{
       this.checkUserRole();
     },1000);  
   },
   created(){

   },
   methods:{
      
       checkUserRole(){
        //  alert('boot startup ... ');
         if (this.isLineManager()){
             this.rateYourself();
         }else if (this.isAdmin()){
             location.hash = '/departmental-kpi';
         }else{
             this.rateYourself();
         }
       }


   }
 

};
</script>

