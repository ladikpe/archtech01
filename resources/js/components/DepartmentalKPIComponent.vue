<template>
  <!-- start -->

  <div class="row">

<modal name="kpi-form" :height="'269px'">


    <div class="col-md-12" style="border-left: 1px solid #bbb;padding: 0;">

    <div slot="top-right" style="text-align: right;padding: 7px;">
      <button @click="$modal.hide('kpi-form')">
        ❌
      </button>
    </div>


      <form @submit.prevent="validateInput">
        <div class="col-xs-12">
          <h4>{{ edited? 'Save':'Add' }} Departmental KPI</h4>
        </div>

        <div class="col-xs-12">
          <label for>KPI</label>
          <input type="text" v-model="data.content" class="form-control" required/>
        </div>

        <div class="col-xs-12">
          <label for>Percentage. %</label>
          <input type="text" v-model="data.percentage" class="form-control" required/>
        </div>


        <div class="col-xs-12" style="margin-top: 11px;">
          <input
            type="submit"
            class="btn btn-sm btn-success"
            :value="edited? 'Save KPI' : 'Add New KPI'"
          />
          <button
            v-show="edited"
            @click.prevent="cancelUpdate()"
            class="btn btn-sm btn-warning"
          >Cancel</button>
        </div>
      </form>
    </div>

</modal>

    <div class="col-xs-12"></div>

    <div class="col-md-12">

      <div class="col-xs-12" align="right">
           <a href="" class="btn btn-sm btn-success" data-toggle="modal" @click.prevent="edited=false;$modal.show('kpi-form')">Add Departmental KPI</a>
      </div>
      <!-- start -->
      <div class="col-xs-4">
        <h4 style="margin:0;">Departmental KPIs</h4>
      </div>

      <div class="col-xs-3" style="padding:0;">
        <!-- <div class="col-xs-12">
                    <label for="">Select Department</label>
        </div>-->

        <div class="col-xs-12" style="padding: 0;">
          <select v-model="data.dept_id" class="select-css">
            <option value>Select Department</option>
            <option
              v-for="dept_id in dept_ids"
              :value="dept_id.id"
              :key="dept_id.id"
            >{{ dept_id.spec }}</option>
          </select>
        </div>
      </div>

      <div class="col-xs-2">
        <!-- <div class="col-xs-12">
                        <label for="">Select Year</label>
        </div>-->

          <!-- "/api/get-kpi-department/" + this.data.dept_id + "/" + this.data.kpi_frequency_id -->


        <div class="col-xs-12" style="padding: 0;">
          <select v-model="data.kpi_frequency_id" class="select-css">
            <option value>Select Year</option>
            <option v-for="year in years" :value="year.id" :key="year.id">{{ year.year }}</option>
          </select>
        </div>
      </div>
      <!-- stop -->

      <div style="clear: both;"></div>

     
      <!-- <div>{{ kpiDepartments.length }}</div> -->
      <div v-show="kpiDepartments.length <= 0" class="col-xs-12">
        <div class="alert alert-danger" style="text-align: center;margin-top: 11px;"><b>No Kpis For This Selection!</b></div>
      </div>

      <table v-show="kpiDepartments.length" class="table table-striped" style="margin-top: 11px;">
        <tr>
          <th>KPIs</th>
          <th>Percentage. %</th>
          <th style="text-align: right">Options</th>
        </tr>
        <tr v-for="kpiDepartment in kpiDepartments" :key="kpiDepartment.id">
          <td>{{ kpiDepartment.content }}</td>
          <td>{{ kpiDepartment.percentage }}</td>
          <td style="text-align: right">
            <a
              href="#"
              @click.prevent="selectRow(kpiDepartment)"
              class="btn btn-sm btn-primary"
            >Edit</a>

            <a
              href="#"
              @click.prevent="doRemove(kpiDepartment)"
              class="btn btn-sm btn-danger"
            >Remove</a>
          </td>
        </tr>

        <tr>
          <td colspan="1">
            <b style="font-weight: bold;">Total</b>
          </td>
          <td>
            {{ getTotal() }}
          </td>
        </tr>

      </table>
    </div>




<!-- modals here -->
<!-- modal start -->
<div class="modal fade" id="mod1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- modal stop -->



  </div>

  <!-- end  -->
</template>

<script>
export default {
  data() {
    return {
      dept_ids: [],
      id: "",
      data: {
        id: "",
        dept_id: "",
        content: "",
        kpi_frequency_id: "",
        percentage:0
      },
      kpiDepartments: [],
      edited: false,
      years: [],
      headers: { "content-Type": "application/json" }
    };
  },
  mounted() {
    // console.log('Component mounted.');
    this.getDepartments();
    

    this.$root.$emit('menu-change',{
      index:1
    });

    // this.getKpiDepartments();
  },
  watch: {
    "data.dept_id"(o, n) {
      this.getKpiDepartments();
    },
    "data.kpi_frequency_id"(o, n) {
      this.getKpiDepartments();
    }
  },
  methods: {

    getTotal(){
      var r = 0;
      this.kpiDepartments.forEach((val)=>{
        r+=(+val.percentage);
      });
      return r + ' %';
    },


    loadYears() {
      this.data.kpi_frequency_id = 0;
      //http://127.0.0.1:8000/api/kpi-frequency-all
      this.doGet('/api/kpi-frequency-all').then(res=>{
        
        if (this.data.kpi_frequency_id == 0 && res.data.length){
           this.data.kpi_frequency_id = res.data[0].id;
        }

        this.years = res.data;

        this.getKpiDepartments();
        // this.allAssetLoaded = true;

      });

      // let dt = new Date();
      // let year = dt.getFullYear();
      // this.data.year = year;
      // for (let c = 1; c < 5; c++) {
      //   this.years.push(year - c + 1);
      // }
    },


    // loadYears() {
    //   let dt = new Date();
    //   let year = dt.getFullYear();
    //   this.data.year = year;
    //   for (let c = 1; c < 5; c++) {
    //     this.years.push(year - c + 1);
    //   }
    // },

    getDepartments() {
      this.startAjax();
      fetch("/api/get-departments")
        .then(res => res.json())
        .then(res => {
          this.stopAjax();
          this.dept_ids = res.data;
          this.data.dept_id = this.dept_ids[0].id;

          this.loadYears();

        });
    },

    getKpiDepartments() {
      if (this.data.dept_id && this.data.kpi_frequency_id) {
        this.startAjax();
        fetch(
          "/api/get-kpi-department/" + this.data.dept_id + "/" + this.data.kpi_frequency_id
        )
          .then(res => res.json())
          .then(res => {
            this.stopAjax();
            this.kpiDepartments = res.data;
          });
      }
    },

    validateInput() {
      if (this.data.dept_id && this.data.kpi_frequency_id) {
        this.save();
      } else {
        toastr.error("Please select a department and year!");
      }
    },

    save() {
      // alert('Called.');

      if (this.edited) {
        this.doSave();
      } else {
        this.doCreate();
      }

      //   this.edited = false;
      this.cancelUpdate();
    },

    doSave() {
      this.startAjax();
      fetch("/api/update-kpi-department/" + this.data.id, {
        method: "POST",
        body: this.getInput(),
        headers: this.headers
      })
        .then(res => res.json())
        .then(res => {
          this.stopAjax();
          this.getKpiDepartments();
          toastr.info(res.message); //'KPI-Department Saved.'
          this.$modal.hide('kpi-form');
        });
    },

    doCreate() {
      this.startAjax();
      fetch("/api/store-kpi-department", {
        method: "POST",
        body: this.getInput(),
        headers: this.headers
      })
        .then(res => res.json())
        .then(res => {
          this.stopAjax();
          this.getKpiDepartments();
          toastr.info(res.message); //'KPI-Department Added.'
          this.$modal.hide('kpi-form');
        });
    },

    doRemove(data) {
      //remove-kpi-department
      if (confirm("Do you want to confirm this action?")) {
        this.startAjax();
        fetch("/api/remove-kpi-department/" + data.id, {
          method: "POST",
          body: this.getInput(),
          headers: this.headers
        })
          .then(res => res.json())
          .then(res => {
            this.stopAjax();
            this.getKpiDepartments();
            toastr.info(res.message); //'KPI-Department Added.'
          });
      }
    },

    selectRow(data) {
      //   this.data = data;
      this.data.dept_id = data.dept_id;
      this.data.content = data.content;
      // this.data.year = data.year;
      this.data.id = data.id;
      this.data.percentage = data.percentage;

      this.edited = true;


      this.$modal.show('kpi-form');

    },

    getInput() {
      return JSON.stringify({
        dept_id: this.data.dept_id,
        content: this.data.content,
        kpi_frequency_id: this.data.kpi_frequency_id,
        _token: laravel.csrfToken,
        percentage: this.data.percentage
      });
      // return ;
    },

    cancelUpdate() {
      this.edited = false;
      this.data.content = "";
      this.data.percentage = 0;
    }
  }
};
</script>

<style scoped>
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
td, th { 
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
    width: 100%;
    max-width: 100%; 
    box-sizing: border-box;
    margin: 0;
    border: 1px solid #aaa;
    box-shadow: 0 1px 0 1px rgba(0,0,0,.04);
    border-radius: .5em;
    -moz-appearance: none;
    -webkit-appearance: none;
    appearance: none;
    background-color: #fff;
    background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23007CB2%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'),
      linear-gradient(to bottom, #ffffff 0%,#e5e5e5 100%);
    background-repeat: no-repeat, repeat;
    background-position: right .7em top 50%, 0 0;
    background-size: .65em auto, 100%;
}
.select-css::-ms-expand {
    display: none;
}
.select-css:hover {
    border-color: #888;
}
.select-css:focus {
    border-color: #aaa;
    box-shadow: 0 0 1px 3px rgba(59, 153, 252, .7);
    box-shadow: 0 0 0 3px -moz-mac-focusring;
    color: #222; 
    outline: none;
}
.select-css option {
    font-weight:normal;
}


body {
  padding: 3rem;
}

</style>

