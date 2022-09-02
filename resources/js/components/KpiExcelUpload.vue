<template>
 

 <span>

 <div class="col-md-12">
 
     <h3>Bulk Upload</h3>

    <div class="form-group">
      <input type="file" class="form-control" ref="excel" />
    </div>

    <div class="form-group">
      <a :href="'/kpi_department_template.xlsx'"><b>Download Template</b></a>
    </div>


    <div class="form-group" align="right"> 
      <button class="btn btn-sm btn-success" @click.prevent="doBulkUpload">Upload Excel</button>
    </div>
 </div>

 </span>


</template>

<script>
import Axios from 'axios';
    
    export default {
        mounted(){
            console.log('Component mounted.')
        },

        props:['kpi_frequency_id','dept_id','api'], //'/api/import-kpi-department-excel'

        methods:{

            doBulkUpload(){
               this.startAjax();
               let frmData = new FormData();
                frmData.append('excel',this.$refs.excel.files[0]);
                frmData.append('dept_id',this.dept_id);
                frmData.append('kpi_frequency_id',this.kpi_frequency_id);
                //api/import-kpi-department-excel
                Axios.post(this.api,frmData,{
                    headers:{
                        'Content-Type':'multipart/form-data'
                    }
                }).then(response=>{
                   this.stopAjax();  
                   this.$emit('reload');
                   console.log(response);
                }).catch(error=>{
                   this.stopAjax();
                   console.log(error);
                });
                
            } 



        }
    }
</script>
