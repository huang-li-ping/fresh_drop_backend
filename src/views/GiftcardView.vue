<template>
  <PageTitle :title="'禮物卡管理'" />
  <div class="container">
    <div class="row">
      <!-- 搜尋框 -->

      <div class="col-4 search_bar_group">
        <div class="input-group">
          <span class="input-group-text">搜尋禮物卡</span>
          <input type="text" class="form-control" placeholder="請輸入名稱" @input="searchIdOrPhone" v-model="searchInput" />
          <div class="btn btn-outline-primary" @click="searchIdOrPhone">搜尋</div>
        </div>
      </div>

      <!-- <div class="col-3">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="搜尋" @input="searchIdOrPhone" v-model="searchInput" />
          <div class="input-group-append">
            <button class="btn btn-outline-primary" type="button" style="margin-left: 10px" @input="searchIdOrPhone">search</button>
          </div>
        </div>
      </div> -->


      <!-- 每頁顯示...筆 -->
      <div class="col-4">
        <span>
          每頁　
          <div class="btn-group">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="defaultDropdown"
              data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
              10
            </button>
            <ul class="dropdown-menu" aria-labelledby="defaultDropdown">
              <li><a class="dropdown-item" href="#">10</a></li>
              <li><a class="dropdown-item" href="#">20</a></li>
              <li><a class="dropdown-item" href="#">30</a></li>
            </ul>
          </div>
          　筆
        </span>
      </div>
      <div class="col-2 create" style="margin-left:auto">
        <button class="btn btn-primary create-btn" type="button" style="margin-left: auto; color: #fff">新增樣式</button>
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
      <tr v-for="(item, index) in searchResult" :key="index">
        <td>
          <button class="edit-button btn btn-sm btn-outline-secondary rounded-5">
            <font-awesome-icon icon="fa-solid fa-pen" />
          </button>
        </td>
        <td>{{ item.id }}</td>
        <td>{{ item.name }}</td>
        <td>{{ item.catogory }}</td>
        <td>{{ item.pic }}</td>
        <td>{{ item.date }}</td>
        <td>{{ item.status }}</td>
        <td>
          <div class="input-group-append">
            <button class="btn btn-outline-primary" type="button" style="margin-left: 10px">下架</button>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
  <!-- 頁碼 -->
  <nav style="padding: 15px">
    <ul class="pagination">
      <li class="page-item">
        <a class="page-link" href="#" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <li class="page-item"><a class="page-link" href="#">1</a></li>
      <li class="page-item"><a class="page-link" href="#">2</a></li>
      <li class="page-item"><a class="page-link" href="#">3</a></li>
      <li class="page-item">
        <a class="page-link" href="#" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>
  </nav>
</template>
<script>
import PageTitle from '@/components/PageTitle.vue';

// import PageComponent from "@/components/PageComponent.vue";
export default {
  name: 'IngredientView',
  component: {
    // PageComponent,
    PageTitle,
  },
  data() {
    return {
      searchInput: '',
      colTitle: ["", "編號", "樣式名稱", "類別", "圖片", "上架日期", "狀態", "上下架"],
      giftcardData: [
        { id: "1", name: "經典鮮食空投箱", catogory: "品牌", pic: "giftcard_defaultpic_001.svg", date: "2023-07-01", status: "上架" },
        { id: "2", name: "香菇經典空投箱", catogory: "品牌", pic: "giftcard_defaultpic_002.svg", date: "2023-07-02", status: "上架" },
        { id: "3", name: "新鮮蔬果", catogory: "品牌", pic: "giftcard_defaultpic_003.svg", date: "2023-07-03", status: "上架" },
        { id: "4", name: "小動物生日快樂", catogory: "品牌", pic: "giftcard_defaultpic_004.svg", date: "2023-07-04", status: "上架" },
        { id: "5", name: "滿版生日快樂", catogory: "品牌", pic: "giftcard_defaultpic_005.svg", date: "2023-07-05", status: "上架" },
        { id: "6", name: "寫實新鮮蔬果", catogory: "品牌", pic: "giftcard_defaultpic_006.svg", date: "2023-07-06", status: "上架" },
      ],
      searchResult: [],
    };
  },
  components: { PageTitle },
  methods: {
    searchIdOrPhone() {
      console.log(this.searchInput);
      if (this.searchInput == '') {
        this.searchResult = this.giftcardData
      }
      let idResult = this.giftcardData.filter(item => {
        return item.id.includes(this.searchInput)
      })
      let phoneResult = this.giftcardData.filter(item => {
        return item.name.includes(this.searchInput)
      })
      if (idResult.length > 0) {
        this.searchResult = idResult
      } else if ((phoneResult.length > 0)) {
        this.searchResult = phoneResult
      }
    }
  },
  created() {
    this.searchResult = this.giftcardData
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

table{
  margin-top: 20px;
}
</style>
