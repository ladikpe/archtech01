<template>

            <div class="row">
              
              

                <div class="col-xs-12" style=";margin-bottom: 25px;font-size: 20px;">
    
                    <router-link v-show="+is_admin == 1" @click.native="currentIndex = 1" to="/departmental-kpi" :class="((currentIndex == 1)? ' current-button ':' ') + 'link'">
                        Setup Departmental KPIs
                    </router-link>
                    <!-- :style="'border-top-left-radius: 15px;'" -->
                    <router-link v-show="+is_admin == 1" to="/manage-organizational-kpi" @click.native="currentIndex = 2" :class="((currentIndex == 2)? ' current-button ':' ') + 'link'">
                           Setup Organizational KPIs
                    </router-link>

                    <router-link v-show="+is_admin != 1" :to="rateYourselfLink()" @click.native="currentIndex = 3"  :class="((currentIndex == 3)? ' current-button ':' ') + 'link'"> 
                          Rate KPIs 
                    </router-link> 


                    <router-link v-show="+is_admin == 1" to="/kpi-frequency" @click.native="currentIndex = 4" :class="((currentIndex == 4)? ' current-button ':' ') + 'link'">
                           Setup KPI Frequency
                    </router-link>


                    <!-- <router-link :to="rateYourselfLink()" @click.native="currentIndex = 4"  :class="((currentIndex == 4)? ' current-button ':' ') + 'link last-curve'">
                          KPI Line-Manager Rate 
                    </router-link>    -->
              
                </div>

<ajax-loader styleString="float: right;position: absolute;left: 82%;top: 4%;" />

            </div>          

</template>

<script>
import { all } from 'q';
// import { setTimeout } from 'timers';
    export default {
        props:[
            'user_id',
            'workdept_id',
            'linemanager_id',
            'is_linemanager',
            'is_admin'
        ],
        data(){
          return {
            buttonList:[1,2,3,4],
            currentIndex:1
          };
        },
        mounted(){
            console.log('Component mounted.');

            // alert(this.user_id);
            // alert(this.workdept_id);
            // alert(this.linemanager_id);
            // alert(this.is_linemanager);
            // alert(this.is_admin);

            this.$root.$on('menu-change',(data)=>{
              this.currentIndex = data.index;
            });

            this.localstorageSave('user_id',this.user_id);
            // this.$user_id = this.user_id;

            this.localstorageSave('linemanager_id',this.linemanager_id);
            // this.$linemanager_id = this.linemanager_id;

            this.localstorageSave('is_linemanager',this.is_linemanager);
            // this.$is_linemanager = this.is_linemanager;

            this.localstorageSave('is_admin',this.is_admin);
            // alert(this.is_admin + '::::');
            // this.$is_admin = this.is_admin;  

            this.localstorageSave('workdept_id',this.workdept_id);
            // this.$workdept_id = this.workdept_id;

            console.log(this);

            // setTimeout(()=>{

              this.checkUserRole();

            // },1000);

        },

        methods:{
            rateYourselfLink(){
               return '/rate-yourself/' + this.user_id + '/' + this.workdept_id + '/' + this.linemanager_id;
            },
            resetToButton(btn){ 
              
              if (btn == this.currentIndex){
                return {
                    backGroundColor:'#000'
                };
              }else{
                return {
                    backGroundColor:'#47b8c6'
                };
              }

            }
        }
    }
</script>

<style scoped>
   .link{
       font-size: 17px;
       padding: 11px;
       background-color: #62a8ea;
       color: #000;
       /* font-weight: bold; */
       text-decoration: none;       
   }

   .first-curve{
       border-top-left-radius: 15px;
   }

   .last-curve{
     border-top-right-radius: 15px;
   }

   .current-button{
     background-color: #0e84b4;
     color: #fff;
   }

   
</style>

