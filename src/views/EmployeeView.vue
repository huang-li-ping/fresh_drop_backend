<template>
  <PageTitle :title="'管理員帳號管理'" />
  <div class="container">
    <div class="row">
      <!-- 搜尋框 -->

      <div class="col-4 search_bar_group">
        <div class="input-group">
          <span class="input-group-text">搜尋帳號</span>
          <input type="text" class="form-control" placeholder="請輸入名稱" @input="searchIdOrPhone" v-model="searchInput" />
          <div class="btn btn-outline-primary" @click="searchIdOrPhone">搜尋</div>
        </div>
      </div>


      <div class="col-2 create" style="margin-left:auto">
        <button class="btn btn-primary create-btn" @click="openAddModal" type="button" value="新增" style="margin-left: auto; color: #fff" >新增帳號</button>
      </div>
    </div>


  </div>

  <!-- 表格 -->
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col" v-for="(item, index) in colTitle" :key="index">{{ item }}</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(item, index) in showData" :key="index">
        <td>
          <button class="edit-button btn btn-sm btn-outline-secondary rounded-5" @click="openModal(item)" value="修改">
            <font-awesome-icon icon="fa-solid fa-pen" />
          </button>
        </td>
        <td>{{ item.emp_no }}</td>
        <td>{{ item.emp_name }}</td>
        <td>{{ item.emp_id }}</td>
        <td>{{ item.emp_date }}</td>
        <td>{{ status(item) }}</td>
      </tr>
    </tbody>
  </table>
  <!-- 頁碼 -->
  <PageComponent :data="searchResult" @changePage="getPageData" />

  <!-- 修改刪除彈窗 -->

 <form id="revise_employee" method="POST" enctype="multipart/form-data" @submit.prevent action="#">
  <div class="emp_show_modal d-flex flex-column align-items-start gap-2" v-if="showModal">
   
   
    <label for="emp_no">管理員編號：<input type="text" :value="newData.emp_no ||  employeeIdNum()" id="emp_no" name="emp_no"></label>

    <label for="emp_name" class="inline-label">姓名　　　：<input type="text" :value="newData.emp_name" id="emp_name" name="emp_name" ></label>

    <label for="emp_id">帳號　　　：<input type="text" :value="newData.emp_id" id="emp_id" name="emp_id"></label>

    <label for="emp_psw">密碼　　　：<input type="text" :value="newData.emp_psw" id="emp_psw" name="emp_psw"></label>

    <label for="date">加入日期　：<input type="text" :value="newData.emp_date || currentDate()" id="emp_date"  name="emp_date"></label>

    <label for="status">狀態　　　：
      <select name="emp_status" id="emp_status" v-model="newData.emp_status">
        <option value=1>啟用</option>
        <option value=0>停用</option>
      </select></label>


      <button class="btn btn-primary col-12" style="color:#fff" type="submit" name="submit" value="修改" @click="handleSubmit('存檔')">存檔</button>
      <button class="btn btn-outline-secondary col-12" type="submit" name="submit" value="刪除" @click="handleSubmit('刪除')" >刪除</button>


    <!-- 關閉按鍵 -->
    <button class="xmark btn btn-outline-secondary rounded-5" @click="closeModal">
      x
    </button>
 
  </div>
 </form>

 <!-- 新增彈窗 -->

 <form id="revise_employee" method="POST" enctype="multipart/form-data" @submit.prevent action="#">
  <div class="emp_show_modal d-flex flex-column align-items-start gap-2" v-if="showAddModal">
      
    <label for="emp_no">管理員編號：<input type="text" :value="employeeIdNum()" id="emp_no" name="emp_no"></label>

    <label for="emp_name" class="inline-label">姓名　　　：<input type="text" value="" id="emp_name" name="emp_name" ></label>

    <label for="emp_id">帳號　　　：<input type="text" value="" id="emp_id" name="emp_id"></label>

    <label for="emp_psw">密碼　　　：<input type="text" value="" id="emp_psw" name="emp_psw"></label>

    <label for="date">加入日期　：<input type="text" :value="currentDate()" id="emp_date" name="emp_date"></label>

    <label for="status">狀態　　　：
      <select name="emp_status" id="emp_status">
        <option value=1>啟用</option>
        <option value=0>停用</option>
      </select></label>


      <button class="btn btn-primary col-12" style="color:#fff" type="submit" name="submit" value="新增" @click="handleSubmit('新增')">新增</button>
    
    <!-- 關閉按鍵 -->
    <button class="xmark btn btn-outline-secondary rounded-5" @click="closeModal">
      x
    </button>
 
  </div>
 </form>


</template>
<script>
import PageComponent from '@/components/PageComponent.vue';
import PageTitle from '@/components/PageTitle.vue';

export default {
  name: 'IngredientView',
  components: {
    PageTitle,
    PageComponent
  },
  data() {
    return {
      showModal: false, // 修改刪除的彈窗
      showAddModal:false, //新增的彈窗
      newData: [],
      searchInput: '',
      colTitle: ["", "管理員編號", "姓名", "帳號", "加入日期", "狀態"],
      employeeData: [],
      searchResult: [],
      showData: [],
    };
  },

  methods: {
    searchIdOrPhone() {
      console.log(this.searchInput);
      if (this.searchInput == '') {
        this.searchResult = this.employeeData
      }
      let idResult = this.employeeData.filter(item => {
        return item.emp_no.includes(this.searchInput)
      })
      let phoneResult = this.employeeData.filter(item => {
        return item.emp_name.includes(this.searchInput)
      })
      if (idResult.length > 0) {
        this.searchResult = idResult
      } else if ((phoneResult.length > 0)) {
        this.searchResult = phoneResult
      }
    },
    getPageData(data) {
      this.showData = data
    },
    openModal(item) {
      this.showModal = true;
      this.newData = item;
      console.log(this.newData)

    },
    openAddModal() {
      this.showAddModal = true;

    },
    closeModal() {
      this.showModal = false;
      this.showAddModal = false;

    },
    currentDate() {
      const current = new Date();
      const date = `${current.getFullYear()}-${current.getMonth()+1}-${current.getDate()}`;
      return date;
    },

    getEmployeeData() {
      let url = `${this.$url}employeeRows.php`
      this.axios.get(url).then(res => {
        this.employeeData = res.data
      }).catch(err => {
        console.log(err);
      })
    },
    status(item){
      let status = item.emp_status;
      if( status == 1){
        return "啟用";
      }else if( status == 0){
        return "停用";
      }
    },
    employeeIdNum(){
      const employeeIdNum = this.employeeData.length +1;
      return employeeIdNum;
    },
    handleSubmit(submitType) {
      let url = `${this.$url}employeeInsertUpdate.php`
      const formData = new FormData();
      const emp_id = document.querySelector('#emp_id')?.value;
      const emp_no = document.querySelector('#emp_no')?.value;
      const emp_name = document.querySelector('#emp_name')?.value;
      const emp_psw = document.querySelector('#emp_psw')?.value;
      const emp_date = document.querySelector('#emp_date')?.value;
      const emp_status = document.querySelector('#emp_status')?.value;
      formData.append("emp_no", emp_no);
      formData.append("emp_name", emp_name);
      formData.append("emp_id", emp_id);
      formData.append("emp_psw", emp_psw);
      formData.append("emp_date", emp_date);
      formData.append("emp_status", emp_status);
      formData.append("submit", submitType);

      this.axios.post(url, formData).then(res => {
        console.log(res)
        this.getEmployeeData()
        this.closeModal()
      }).catch(err => {
        console.log(err);
      })
    },

    
    
   
  },


  watch: {
    employeeData: {
      handler: function () {
        this.searchResult = this.employeeData
      },
      deep: true
    },
  },
  mounted() {
    this.getEmployeeData()
  },
};
</script>

<style lang="scss">
// @import 'bootstrap/dist/css/bootstrap.min.css';
// @import '@/assets/scss/all.scss';
@import "@/assets/scss/page/ingredients.scss";

.create {
  display: flex;
}

.create-btn {
  margin-left: auto;
}

table {
  margin-top: 20px;
}

.emp_show_modal {
  border: 3px solid #1F8D61;
  border-radius: 20px;
  width: fit-content;
  padding: 50px 30px 30px 30px;
  position: absolute;
  position: fixed;
  left: 40%;
  top: 30%;
  font-weight: 700;
  background-color: #FFF7EA;
  z-index: 10;


  .xmark {
    right: 5px;
    top: 5px;
    position: absolute;
  }

   label {

    input {
      padding: 0 5px;
      margin-left: 5px;
    

    }

    select{
      height: 28px;
    }
   }}
</style>
