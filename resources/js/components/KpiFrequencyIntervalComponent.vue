<template>

    <div class="row" style="padding: 11px;">
    
   <!-- modal start -->
   <modal name="kpi-form" :height="'369px'">

    <div class="col-md-12" style="border-left: 1px solid #bbb;padding: 0;">

    <div slot="top-right" style="text-align: right;padding: 7px;">
      <button @click="$modal.hide('kpi-form')">
        ❌
      </button>
    </div>


      <form @submit.prevent="save()">
        <div class="col-xs-12">
          <h4>{{ editMode? 'Save':'Add' }} KPI Frequency Interval</h4>
        </div>

        <div class="col-xs-12">
          <label for>Name</label>
          <input type="text" v-model="data.name" class="form-control" />
        </div>


        <div class="col-xs-12">
          <label for>Date Start</label>
          <input type="date" v-model="data.date_start" class="form-control" />
        </div>

        <div class="col-xs-12">
          <label for>Date Stop</label>
          <input type="date" v-model="data.date_stop" class="form-control" />
        </div>


        <div class="col-xs-12" style="margin-top: 11px;">
          <input
            type="submit"
            class="btn btn-sm btn-success"
            :value="editMode? 'Save KPI Frequency Interval' : 'Add New KPI Frequency Interval'"
          />
          <button
            v-show="editMode"
            @click.prevent="unpick()"
            class="btn btn-sm btn-warning"
          >Cancel</button>
        </div>
      </form>
    </div>
   </modal>  
   <!-- modal stop -->



    <div class="col-xs-12"></div>

    <div class="col-md-12">


      <div class="col-xs-12" align="right">
           <a href="" class="btn btn-sm btn-success" data-toggle="modal" @click.prevent="unpick();$modal.show('kpi-form')">Add KPI Frequency-Interval</a>
      </div>


      <!-- start -->
      <div class="col-xs-12">
        <h4 style="margin:0;">KPI Frequency Interval</h4>
      </div>


      <!-- stop -->

      <div style="clear: both;"></div>


      <div v-show="list.length <= 0" class="col-xs-12">
        <div class="alert alert-info" style="text-align: center;margin-top: 11px;"><b>No Kpis Frequency Interval Configured For This Year!</b></div>
      </div>


    <div style="display: block;height: 280px;overflow-y:scroll;">

      <table v-show="list.length" class="table table-striped" style="margin-top: 11px;">
        
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Date Start</th>
          <th>Date Stop</th>
          <th>Date Created</th>
          <th style="text-align: right">Options</th>
        </tr>

        <tr v-for="( lst , k ) in list" :key="lst.id">
          <td>{{ k+1 }}</td>  
          <td>{{ lst.name }}</td>
          <td>{{ lst.date_start }}</td>
          <td>{{ lst.date_stop }}</td>
          <td>{{ lst.created_at }}</td>
          <td style="text-align: right">
            <a
              href="#"
              @click.prevent="pick(lst);$modal.show('kpi-form');"
              class="btn btn-sm btn-primary"
            >Edit</a>

            <a
              href="#"
              @click.prevent="pick(lst);doDelete()"
              class="btn btn-sm btn-danger"
            >Remove</a>

          </td>
        </tr>


      </table>

      </div>

    </div>


    </div>          

</template>

<script>

export default {
        data(){
           return {
              data:{
                  user_id:laravel.userId,
                  date_start:'',
                  date_stop:'',
                  name:''
              }
           };
        },
        props:[
            'kpi_frequency_id'
        ],
        mounted(){
            console.log('Component mounted.');
            this.doFetch();
        },

        methods:{
            
            getCreateApi(){
              
              this.data.user_id = laravel.userId;
              this.data.kpi_frequency_id = this.kpi_frequency_id;

              return 'api/kpi-frequency-interval-create';
            },
            getDeleteApi(id){
              return 'api/kpi-frequency-interval-delete/' + id;
            },
            getUpdateApi(id){
             return 'api/kpi-frequency-interval-update/' + id;
            },
            getFetchApi(){
              return 'api/kpi-frequency-interval-all/' + this.kpi_frequency_id;
            },
            afterFetch(){
                this.$modal.hide('kpi-form');
            }

         }
    }
</script>

<style scoped>
.v--modal-overlay {
  z-index: 90000;
}

table {
  width: 100%;
  border-collapse: collapse;
}
/* Zebra striping */
tr:nth-of-type(odd) {
  background: #eee;
}
th {
  background: #62a8ea;
  color: white;
  font-weight: bold;
}
td,
th {
  padding: 6px;
  border: 1px solid #62a8ea;
  text-align: left;
}

.select-css {
  display: block;
  font-size: 16px;
  font-family: sans-serif;
  font-weight: 700;
  color: #444;
  line-height: 1.3;
  padding: 5px;
  /* .6em 1.4em .5em .8em */
  width: 100%;
  max-width: 100%;
  box-sizing: border-box;
  margin: 0;
  border: 1px solid #aaa;
  box-shadow: 0 1px 0 1px rgba(0, 0, 0, 0.04);
  border-radius: 0.5em;
  -moz-appearance: none;
  -webkit-appearance: none;
  appearance: none;
  background-color: #fff;
  background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23007CB2%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E"),
    linear-gradient(to bottom, #ffffff 0%, #e5e5e5 100%);
  background-repeat: no-repeat, repeat;
  background-position: right 0.7em top 50%, 0 0;
  background-size: 0.65em auto, 100%;
}
.select-css::-ms-expand {
  display: none;
}
.select-css:hover {
  border-color: #888;
}
.select-css:focus {
  border-color: #aaa;
  box-shadow: 0 0 1px 3px rgba(59, 153, 252, 0.7);
  box-shadow: 0 0 0 3px -moz-mac-focusring;
  color: #222;
  outline: none;
}
.select-css option {
  font-weight: normal;
}

body {
  padding: 3rem;
}
</style>