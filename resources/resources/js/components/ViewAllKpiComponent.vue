<template>
  <!-- start -->

  <div class="row">
    
    

    <!-- modal start -->
    <modal name="rate-yourself" :resizable="true" :height="'479px'">
      <kpi-rate-form-user
        :percentage="data.percentage"
        :user_id="currentUserKpi.user_id"
        :group_id="currentUserKpi.group_id"
        :user_rate="currentUserKpi.user_rate"
        :linemanager_rate="currentUserKpi.linemanager_rate"
        :comments="currentUserKpi.comments"
        :linemanager_comments="currentUserKpi.linemanager_comments"
        :label="'KPI Rate Yourself : '"
        :editing="fetching"
        :users="users"
        :kpi_label="data.content"
        :loading="loading"
        @submit="validateInputIndividual"
        @close="$modal.hide('rate-yourself')"
      ></kpi-rate-form-user>
    </modal>

    <!-- modal stop -->

    <!-- modal start -->
    <modal name="rate-user" :resizable="true" :height="'479px'">
      <kpi-rate-form-linemanager
        :percentage="data.percentage"
        :user_id="currentUserKpi.user_id"
        :linemanager_id="userId"
        :group_id="currentUserKpi.group_id"
        :user_rate="currentUserKpi.user_rate"
        :linemanager_rate="currentUserKpi.linemanager_rate"
        :comments="currentUserKpi.comments"
        :linemanager_comments="currentUserKpi.linemanager_comments"
        :label="'KPI Rate By Line-Manager : '"
        :editing="fetching"
        :users="users"
        :kpi_label="data.content"
        :loading="loading"
        @submit="validateInputLineManager"
        @close="$modal.hide('rate-user')"
      ></kpi-rate-form-linemanager>
    </modal>
    <!-- modal stop -->

    <div class="col-xs-12"></div>

    <div class="col-md-12">
      <!-- start -->
      <div class="col-xs-12" style="margin-bottom: 11px;">
        <h4
          style="margin:0;"
        >Rate yourself / {{ (dept_ids.length)? getDepartmentLabel() : 'Loading Department ... ' }}</h4>
      </div>

      <div class="col-xs-3" style="padding:0;">
        <div class="col-xs-12">
          <select v-model="category" class="select-css">
            <option :value="{a:'/api/get-kpi-department/',b:'api/kpi-get-user-value-department/'}">Departmental</option>
            <option :value="{a: '/api/get-kpi-organization/',b:'api/kpi-get-user-value-organization/'}">Organizational</option>
            <!-- <option value="/api/get-kpi-department/">Departmental KPI-Category</option> -->
          </select>
        </div>
      </div>

      <div class="col-xs-2">
        <!-- <div class="col-xs-12">
                        <label for="">Select Year</label>
        </div>-->
        <div class="col-xs-12" style="padding: 0;">
          <select v-model="data.year" class="select-css">
            <option value>Select Year</option>
            <option v-for="year in years" :value="year.id" :key="year.id">{{ year.year }}</option>
          </select>
        </div>
      </div>
      <!-- stop -->

      <!-- intervals -->

      <div class="col-xs-3" v-show="intervals.length > 0">
        <select class="select-css" v-model="currentInterval">
          <option value>-- Select Interval --</option>
          <option
            v-for="interval in intervals"
            :value="interval"
            :key="interval.id"
          >{{ interval.name }}</option>
        </select>
      </div>

      <div class="col-xs-3">
        <select class="select-css" v-model="currentUserKpi.user_id">
          <option value>-- Select User --</option>
          <option v-for="user in users" :value="user.id" :key="user.id">{{ user.name }}</option>
        </select>
      </div>

      <div style="clear: both;"></div>

      <!-- <div>{{ kpiDepartments.length }}</div> -->
      <div v-show="kpiDepartments.length <= 0" class="col-xs-12">
        <div class="alert alert-danger" style="text-align: center;margin-top: 11px;">
          <b>No Kpis For This Selection!</b>
        </div>
      </div>

      <table v-show="kpiDepartments.length" class="table table-striped" style="margin-top: 11px;">
        <tr>
          <th style="width: 100px;">S/N</th>
          <th style="width: 340px;">KPIs</th>
          <th style="width: 340px;">Percentage. %</th>
          <th style="width: 340px;">Personal %</th>
          <th style="width: 340px;">Manager %</th>
          <th style="text-align: right;width: 340px;">Actions</th>
        </tr>
        <tr v-for="(kpiDepartment,k) in kpiDepartments" :key="kpiDepartment.id">
          <td>{{ k+1 }}</td>
          <td>{{ kpiDepartment.content }}</td>
          <td>{{ kpiDepartment.percentage }}</td>
          <td><kpi-user-value 
            field="user_rate" 
            :data1="kpiDepartment"/></td>
          <!-- {{ getSelectedUserRate(kpiDepartment.group_users).user_rate }} -->
          <td><kpi-user-value field="linemanager_rate"
            :data1="kpiDepartment"            
            /></td>
          <!-- {{ getSelectedUserRate(kpiDepartment.group_users).linemanager_rate }} -->
          <td style="text-align: right">
            <select
              v-model="menuIndicator"
              name
              id
              class="select-css"
              @change="handleMenu(kpiDepartment)"
            >
              <option value>Actions</option>
              <!-- <option value="preview">Preview</option> -->
              <option v-show="isLineManager" value="line-manager-rating">Line Manager Rating</option>
              <option v-show="isOther" value="personal-rating">Personal Rating</option>
            </select>
          </td>
        </tr>
      </table>
    </div>

    <div class="col-md-12">
      <!-- http://127.0.0.1:8000/api/kpi-user-get-score/user_rate/172/2 -->
      <b style="
    font-size: 20px;
    font-weight: bold;
    text-transform: uppercase;
">User Score: {{ user_rate }}</b>  / 
<b style="
    font-size: 20px;
    font-weight: bold;
    text-transform: uppercase;
    color:#076184;
">Line Manager Score: {{ linemanager_rate }}</b> 
    </div>
  </div>

  <!-- end  -->
</template>

<script>
import { setTimeout } from "timers";
export default {
  data() {
    return {
      allAssetLoaded: false,
      dept_ids: [],
      id: "",
      data: {
        id: "",
        dept_id: "",
        content: "",
        year: "",
        percentage: 0
      },
      userData: {
        percentage: ""
      },
      kpiDepartments: [],
      edited: false,
      years: [],
      headers: { "content-Type": "application/json" },
      userId: "",
      workdeptId: "",
      linemanagerId: "",
      category: {a: "/api/get-kpi-department/",b:'api/kpi-get-user-value-department/'},
      users: [],
      currentUserKpi: {
        user_id: "",
        group_id: "",
        user_rate: "",
        linemanager_rate: "",
        comments: "",
        linemanager_comments: "",
        linemanager_id: "",
        content: ""
      },
      hasCurrentInterval: false,
      currentInterval: {},
      intervals: [],
      kpi_frequency_interval_id: "",
      apiPointer: {
        ///api/rate-kpi-department-by-me/

        "/api/get-kpi-department/": {
          individual: "/api/rate-kpi-department-by-me/",
          linemanager: "/api/rate-kpi-department-by-thirdparty/",
          group: "/api/get-kpi-user-department/"
        },
        "/api/get-kpi-organization/": {
          individual: "/api/rate-kpi-organization-by-me/",
          linemanager: "/api/rate-kpi-organization-by-thirdparty/",
          group: "/api/get-kpi-user-organization/"
        }
      },
      fetching: true,
      menuIndicator: "",
      loading: 0,

      user_rate: '',
      linemanager_rate: ''

    };

  },
  mounted() {
    //check kpi valid interval
    this.getIntervalForCurrentYear();
    // console.log('Component mounted.');
    this.getDepartments();

    // alert(this.$route.params.userId);
    this.userId = this.$route.params.userId;
    this.workdeptId = this.$route.params.workdeptId;
    this.linemanagerId = this.$route.params.linemanagerId;

    this.data.dept_id = this.workdeptId;

    // this.getKpiDepartments();

    // this.loadUsers();

    this.$root.$emit("menu-change", {
      index: 3
    });


    // this.localstorageSave('email','nnamware@yahoo.com');

    // this.resetCurrentUserKpi(); //reset current KPI's ...
  },
  watch: {
    currentInterval(n, o) {
      // console.log(this.currentInterval,this.allAssetLoaded);
      //currentInterval
      if (this.allAssetLoaded) {     
        this.getKpiDepartments();
        this.getUserScore(this.currentUserKpi.user_id,this.currentInterval.id);   
        this.getLineManagerScore(this.currentUserKpi.user_id,this.currentInterval.id);
      } 

      

    },
    "data.dept_id"(n, o) {
      if (this.allAssetLoaded) this.getKpiDepartments();
    },
    "data.year"(n, o) {
      if (this.allAssetLoaded) {
        this.getKpiDepartments();
        this.getIntervals();
      }
    },
    "userData.percentage"(n, o) {
      // console.log(o,n);
      if (n > this.data.percentage) {
        setTimeout(() => {
          this.userData.percentage = "";
        }, 2000);
        //   this.userData.percentage = n;
      }
    },
    category(n, o) {
      if (this.allAssetLoaded) {     
        this.getKpiDepartments();
      }  
    },
    menuIndicator(n, o) {
      this.menuIndicator = "";
    },
    "currentUserKpi.user_id"(n, o) {
      if (this.allAssetLoaded) {
        this.getKpiDepartments();
        this.getUserScore(this.currentUserKpi.user_id,this.currentInterval.id);   
        this.getLineManagerScore(this.currentUserKpi.user_id,this.currentInterval.id);
      }
      // this.refreshUserRatings(this.kpiDepartments);
    }
  },
  methods: {
    getUserScore(userId,intervalId){
      // alert('/api/kpi-user-get-score/user_rate/' + userId + '/' + intervalId);
        this.doGet('/api/kpi-user-get-score/user_rate/' + userId + '/' + intervalId)
        .then(res=>{
          this.user_rate = res.data.score;
        });
    },
    getLineManagerScore(userId,intervalId){
        this.doGet('/api/kpi-user-get-score/linemanager_rate/' + userId + '/' + intervalId)
        .then(res=>{
          this.linemanager_rate = res.data.score;
        });
    },

    handleMenu(data) {
      var menu = this.menuIndicator;

      if (menu == "line-manager-rating") {
        this.selectRowLinemanager(data);
      } else if (menu == "personal-rating") {
        if (this.currentUserKpi.user_id != "") {
          this.selectRowIndividual(data);
        } else {
          toastr.error("Please select a user!");
        }
      } else if (menu == "preview") {
      }
      // console.log(data);
      // alert('changed ... ');
    },

    getIntervals() {
      this.doGet("/api/kpi-frequency-interval-all/" + this.data.year).then(
        res => {
          this.intervals = res.data;

          this.loadUsers();

          // alert(JSON.stringify(this.intervals));
        }
      );
    },

    // refreshUserRatings(list){

    //     list.forEach((value)=>{
    //       // setTimeout(()=>{
    //         this.getUserKpiDepartment(value);
    //       // },1000);
    //     });

    // },

    getSelectedUserRate(list) {
      var r = {
        user_rate: "N/A",
        linemanager_rate: "N/A"
      };

      list.forEach(value => {
        if (this.currentUserKpi.user_id == value.user_id) {
          r = value;
        }
      });

      return r;
    },

    ///http://127.0.0.1:8000/api/kpi-frequency-get-by-year-current-year
    getIntervalForCurrentYear() {
      this.doGet("/api/kpi-frequency-get-by-year-current-year").then(res => {
        //  alert(JSON.stringify(res));
        console.log(res);
        if (res.data.current_interval == null) {
          //no current interval
          this.hasCurrentInterval = false;
        } else {
          this.hasCurrentInterval = true;
          this.currentInterval = res.data.current_interval;
        }

        console.log(this.currentInterval);
      });
    },

    // resetCurrentUserKpi(){
    //     // this.currentUserKpi.user_id = '';
    //     this.currentUserKpi.kpi_department_id = '';
    //     this.currentUserKpi.user_rate = '';
    //     this.currentUserKpi.linemanager_rate = '';
    //     this.currentUserKpi.comments = '';
    //     this.currentUserKpi.linemanager_comment = '';
    //     this.currentUserKpi.linemanager_id =  '';
    // },

    getUserKpiGroup(kpiGroup) {
      //api/get-kpi-user-department/{user}/{kpiDepartment}
      //kpi_frequency_interval_id
      this.fetching = true;
      this.startAjax();
      fetch(
        this.apiPointer[this.category.a].group +
          this.currentUserKpi.user_id +
          "/" +
          kpiGroup.id + 
          '/' +
          this.currentInterval.id //kpiGroup.id
      )
        .then(res => res.json())
        .then(res => {
          this.stopAjax();
          this.fetching = false;

          if (typeof res.data.length == "undefined") {
            // this.currentUserKpi.user_id = res.data.user_id;
            this.currentUserKpi.group_id = res.data.group_id;
            this.currentUserKpi.user_rate = res.data.user_rate;
            this.currentUserKpi.linemanager_rate = res.data.linemanager_rate;
            this.currentUserKpi.comments = res.data.comments;
            this.currentUserKpi.linemanager_comments = res.data.linemanager_comments;
            this.currentUserKpi.linemanager_id = res.data.linemanager_id;
            // kpiDepartment.user_rate = this.currentUserKpi.user_rate;
            // kpiDepartment.linemanager_rate = this.currentUserKpi.linemanager_rate;
          } else {
            // this.currentUserKpi = {}; //reset this entry .... 
            this.currentUserKpi.user_rate = '';
            this.currentUserKpi.linemanager_rate = '';
            this.currentUserKpi.comments = '';
            this.currentUserKpi.linemanager_comments = '';

            // this.currentUserKpi.user_rate = 'N/A';
            // this.currentUserKpi.linemanager_rate = 'N/A';
            ///Fallback update.
            // kpiDepartment.user_rate = this.currentUserKpi.user_rate;
            // kpiDepartment.linemanager_rate = this.currentUserKpi.linemanager_rate;
          }

          // console.log(kpiDepartment);

          this.currentUserKpi.group_id = this.data.id; // res.data.kpi_department_id;
          // this.currentUserKpi.user_id = this.userId;
        });
    },

    getDepartmentLabel() {
      var r = "";
      this.dept_ids.forEach((v, k) => {
        //workdeptId
        if (v.id == this.workdeptId) {
          r = v.spec;
        }
      });
      return r;
    },

    loadUsers() {
      this.startAjax();
      //http://127.0.0.1:8000/api/get-users?workdept_id=42
      fetch("/api/get-users?workdept_id=" + this.workdeptId)
        .then(res => res.json())
        .then(res => {
          this.stopAjax();
          this.users = res.data;

          let list = [];

          if (this.isOther) {
            res.data.forEach(value => {
              if (value.id == this.getUserId()) {
                list.push(value);
              }
            });
            this.users = list;
          }
        });
    },

    loadYears() {
      this.startAjax();
      this.data.year = 0;
      //http://127.0.0.1:8000/api/kpi-frequency-all
      this.doGet("/api/kpi-frequency-all").then(res => {
        this.stopAjax();
        if (this.data.year == 0 && res.data.length) {
          this.data.year = res.data[0].id;
        }
        this.years = res.data;

        this.getKpiDepartments();

        this.allAssetLoaded = true;
      });

      // let dt = new Date();
      // let year = dt.getFullYear();
      // this.data.year = year;
      // for (let c = 1; c < 5; c++) {
      //   this.years.push(year - c + 1);
      // }
    },

    getDepartments() {
      this.startAjax();
      fetch("/api/get-departments")
        .then(res => res.json())
        .then(res => {
          this.stopAjax();
          this.dept_ids = res.data;
          this.loadYears();
        });
    },

    getKpiDepartments() {

      let query = '?';

      query+='user_id=' + this.currentUserKpi.user_id;
      query+='&kpiFrequencyIntervalId=' + this.currentInterval.id;

      this.startAjax();
      // kpiFrequencyIntervalId
      if (this.workdeptId && this.data.year) {
        // console.log(this.category.a + this.workdeptId + "/" + this.data.year + '/' + this.currentInterval.id);
        fetch(this.category.a + this.workdeptId + "/" + this.data.year + query)
          .then(res => res.json())
          .then(res => {
            this.stopAjax();
            this.kpiDepartments = res.data;
            this.$root.$emit('trigger-values');

            if (this.isOther){
              this.currentUserKpi.user_id = this.getUserId();
            }

          });
      } else {
        toastr.error('Either of department or year can"t be left blank!');
      }
    },

    validateInputIndividual(data) {
      this.loading = 1;
      this.startAjax();
      fetch(
        this.apiPointer[this.category.a].individual +
          data.user_id +
          "/" +
          data.group_id +
          '/' +
          this.currentInterval.id,//data.group_id,
        {
          method: "POST",
          body: JSON.stringify({
            user_id: data.user_id,
            kpi_frequency_interval_id: this.currentInterval.id, //data.group_id,
            comments: data.comments,
            user_rate: data.user_rate,
            _token: laravel.csrfToken
          }),
          headers: this.headers
        }
      )
        .then(res => res.json())
        .then(res => {
          this.stopAjax();
          this.$modal.hide("rate-yourself");
          toastr.info(res.message); //'KPI-Department Saved.'
          this.getKpiDepartments();
          this.loading = 0;
        });
    },

    validateInputLineManager(data) {
      //  console.log(data);
      this.startAjax();
      this.loading = 1;
      fetch(
        this.apiPointer[this.category.a].linemanager +
          data.user_id +
          "/" +
          data.group_id + 
          '/' + 
          this.currentInterval.id,//data.group_id,
        {
          method: "POST",
          body: JSON.stringify({
            user_id: data.user_id,
            linemanager_id: data.linemanager_id,
            kpi_frequency_interval_id: this.currentInterval.id, //data.group_id,
            linemanager_comments: data.linemanager_comments,
            linemanager_rate: data.linemanager_rate,
            _token: laravel.csrfToken
          }),
          headers: this.headers
        }
      )
        .then(res => res.json())
        .then(res => {
          this.stopAjax();
          this.$modal.hide("rate-user");
          toastr.info(res.message); //'KPI-Department Saved.'
          this.getKpiDepartments();
          this.loading = 0;
        });
    },

    pickRow(data) {
      // this.data = {}; //reset data always.
      this.data.dept_id = data.dept_id;
      this.data.content = data.content;
      // this.data.year = data.year;
      this.data.id = data.id;
      this.data.percentage = data.percentage;
      this.edited = true;
    },

    selectRowIndividual(data) {
      this.pickRow(data);
      this.getUserKpiGroup(data);
      this.$modal.show("rate-yourself");
    },

    selectRowLinemanager(data) {
      this.pickRow(data);
      this.getUserKpiGroup(data);
      this.$modal.show("rate-user");
    },

    getInput() {
      return JSON.stringify({
        dept_id: this.data.dept_id,
        content: this.data.content,
        year: this.data.year,
        _token: laravel.csrfToken,
        percentage: this.data.percentage
      });
    }
  }
};
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
