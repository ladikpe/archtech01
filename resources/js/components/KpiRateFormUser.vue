<template>

  <span>


    <div slot="top-right" style="text-align: right;padding: 7px;">
      <button @click="$emit('close')">
        ❌
      </button>
    </div>


    <div class="col-md-12" v-show="editing">
       <h3 style="
    font-size: 15px;
    text-align: center;
    margin-top: 22%;">
         Fetching Selected User Kpi ...   
       </h3>  
    </div> 

    <div v-show="!editing" class="col-md-12" style="border-left: 1px solid #bbb;">
      <form @submit.prevent="$emit('submit',data);">
        <div class="col-xs-12">
          <h4>{{ label + ' (' + getUserLabel() + ')' }}</h4>
        </div>
       
       <!-- <span> -->

        <div class="col-xs-12">
          <label for>Key Performance Indicator</label>
          <div class="alert alert-info">
              <b style="font-weight: bold;color: #444;">
                   {{ kpi_label }}
              </b>
          </div>
        </div>


        <div class="col-xs-12">
          <label for>Line Manager Rate / Comment</label>
          <div class="alert alert-info">
              <b style="font-weight: bold;color: #444;">
                   {{ (linemanager_rate? linemanager_rate : 'pending') }}%
              </b>/<b style="font-weight: bold;color: #444;">
                   {{ (linemanager_comments? linemanager_comments : 'pending') }}
              </b>
          </div>
        </div>


        <div class="col-xs-12">
          <label for>Percentage. %</label>
          <input :max="data.percentage" v-model="data.user_rate" :placeholder="'Max ' + percentage + ' % '" type="text" class="form-control" :style="(+data.user_rate > +percentage)? {border:'2px solid red'}:{border:'1px solid #ccc'}" required/>
           <span style="color: red;" v-show="(+data.user_rate > +percentage)">
               Can't exceed {{ percentage }} %
           </span>
        </div>


        <div class="col-xs-12">
          <label for>Comments</label>
          <textarea v-model="data.comments" class="form-control" placeholder="Comments / Notes " required></textarea>
        </div>


        <div class="col-xs-12" style="margin-top: 11px;">
          
          <input
            type="submit"
            class="btn btn-sm btn-success"
            :value="+loading == 1? 'Sending ...':'Post Rating'"
          />
                    
        </div>
        
        <!-- </span> -->

      </form>
    </div>



  </span>

</template>

<script>

    export default {
        //   this.currentUserKpi.user_id = res.data.user_id;
        //   this.currentUserKpi.kpi_department_id = res.data.kpi_department_id;
        //   this.currentUserKpi.user_rate = res.data.user_rate;
        //   this.currentUserKpi.linemanager_rate = res.data.linemanager_rate;
        //   this.currentUserKpi.comments = res.data.comments;
        //   this.currentUserKpi.linemanager_comment = res.data.linemanager_comment;
        //   this.currentUserKpi.linemanager_id = res.data.linemanager_id;

        props:[
            'percentage',
            'user_id',
            'group_id',
            'user_rate',
            'linemanager_rate',
            'comments',
            'linemanager_comments',
            'label',
            'editing',
            'users',
            'kpi_label',
            'loading'
        ],
        watch:{
            // loading(n){
            //   this._loading = n; 
            // } 
        },

        data(){
          return {
            data:{
                user_id:'',
                group_id:'',
                user_rate:'',
                linemanager_rate:'',
                comments:'',
                linemanager_comments:'',
                _loading:'0'
            }
          };  

        },

        mounted(){
            
            console.log('Component mounted.')
           this.data.user_id = this.user_id;
           this.data.group_id = this.group_id;
           this.data.user_rate = this.user_rate;
           this.data.linemanager_rate = this.linemanager_rate;
           this.data.comments = this.comments;
           this.data.linemanager_comments = this.linemanager_comments;

           // alert(this.comments);
        },
        watch:{
         user_id(n,o){
           this.data.user_id = n;
         },
         group_id(n,o){
           this.data.group_id = n;
         },
         user_rate(n,o){
           this.data.user_rate = n;
         },
         linemanager_rate(n,o){
           this.data.linemanager_rate = n;
         },
         comments(n,o){
           this.data.comments = n;
         },
         linemanager_comments(n,o){
           this.data.linemanager_comments = n;
         }
        },
        methods:{

            getUserLabel(){
                var r = '';
                
                this.users.forEach(element => {
                    if (this.user_id == element.id){
                       r = element.name;
                    }
                });
              
                return r;
            }
             
            //  editing(){
            //      return this.user_id == '';
            //  }


        }

    }
</script>