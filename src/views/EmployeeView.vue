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
        <button class="btn btn-primary create-btn" @click="openModal" type="button" style="margin-left: auto; color: #fff" >新增帳號</button>
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
          <button class="edit-button btn btn-sm btn-outline-secondary rounded-5" @click="openModal(item)">
            <font-awesome-icon icon="fa-solid fa-pen" />
          </button>
        </td>
        <td>{{ item.id }}</td>
        <td>{{ item.name }}</td>
        <td>{{ item.account }}</td>
        <td>{{ item.date }}</td>
        <td>{{ item.status }}</td>
      </tr>
    </tbody>
  </table>
  <!-- 頁碼 -->
  <PageComponent :data="searchResult" @changePage="getPageData" />

  <!-- 彈窗 -->

  <div class="show_modal d-flex flex-column align-items-start gap-2" v-if="showModal">
   
    <label for="id">管理員編號：<input type="text" :value="newData.id || employeeIdNum()" id="id" disabled="disabled"></label>

    <label for="name" class="inline-label">姓名　　　：<input type="text" :value="newData.name" id="name"></label>

    <label for="account">帳號　　　：<input type="text" :value="newData.account" id="account"></label>

    <label for="date">加入日期　：<input type="text" :value="newData.date || currentDate()" id="date" disabled="disabled" ></label>

    <label for="status">狀態　　　：
      <select name="" id="status">
        <option value="">啟用</option>
        <option value="">停用</option>
      </select></label>


    <button class="btn btn-primary col-12 " style="color:#fff">存檔</button>

    <!-- 關閉按鍵 -->
    <button class="xmark btn btn-outline-secondary rounded-5" @click="closeModal">
      x
    </button>
  </div>



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
      showModal: false,
      newData: [],
      searchInput: '',
      colTitle: ["", "管理員編號", "姓名", "帳號", "加入日期", "狀態"],
      employeeData: [
        { id: "1", name: "蔡宗華", account: "abc134", date: "2023-07-01", status: "啟用" },
        { id: "2", name: "黃莉平", account: "qqq12", date: "2023-07-02", status: "停用" },
        { id: "3", name: "李岱林", account: "asd111", date: "2023-07-03", status: "啟用" },
        { id: "4", name: "江瑀停", account: "zzz666", date: "2023-07-04", status: "啟用" },
        { id: "5", name: "許弘義", account: "zxc000", date: "2023-07-05", status: "啟用" },
        { id: "6", name: "徐億藍", account: "qwe122", date: "2023-07-06", status: "啟用" },
        { id: "7", name: "周杰倫", account: "jaychou", date: "2023-07-08", status: "停用" },
        { id: "8", name: "蔡依林", account: "jolin520", date: "2023-07-09", status: "啟用" },
        { id: "9", name: "楊丞琳", account: "rainylove", date: "2023-07-20", status: "啟用" },
        { id: "10", name: "王心凌", account: "cindy555", date: "2023-07-25", status: "啟用" },
        { id: "11", name: "張韶涵", account: "angelinachang", date: "2023-07-31", status: "啟用" },

      ],
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
        return item.id.includes(this.searchInput)
      })
      let phoneResult = this.employeeData.filter(item => {
        return item.name.includes(this.searchInput)
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
    closeModal() {
      this.showModal = false;
    },
    currentDate() {
      const current = new Date();
      const date = `${current.getFullYear()}-${current.getMonth()+1}-${current.getDate()}`;
      return date;
    },
    employeeIdNum(){
      const employeeIdNum = this.employeeData.length +1;
      return employeeIdNum;
    }
 

  },
  created() {
    this.searchResult = this.employeeData
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

.show_modal {
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
  z-index: 2;


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
