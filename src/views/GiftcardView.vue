<template>
  <PageTitle :title="'禮物卡管理'" />
  <div class="container">
    <div class="row">
      <!-- 搜尋框 -->
      <div class="col-3">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="搜尋" />
          <div class="input-group-append">
            <button class="btn btn-outline-primary" type="button" style="margin-left: 10px">search</button>
          </div>
        </div>
      </div>
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
    </div>
  </div>

  <!-- 表格 -->
  <table class="table">
    <thead>
      <tr>
        <th scope="col" v-for="(item, index) in colTitle" :key="index">{{ item }}</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(item, index) in foodData" :key="index">
        <td>
          <button class="edit-button btn btn-sm btn-outline-secondary rounded-5">
            <font-awesome-icon icon="fa-solid fa-pen" />
          </button>
        </td>
        <td>{{ item.id }}</td>
        <td>{{ item.name }}</td>
        <td>{{ item.allergen }}</td>
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
      colTitle: ["", "食材編號", "食材名稱", "過敏原"],
      foodData: [
        { id: "2-01-0-001", name: "越光米", allergen: "無" },
        { id: "2-01-0-002", name: "牛番茄", allergen: "無" },
        { id: "2-01-0-003", name: "伊比利豬", allergen: "有" },
        { id: "2-01-0-001", name: "板腱牛", allergen: "無" },
        { id: "2-01-0-002", name: "雞蛋", allergen: "雞蛋" },
        { id: "2-01-0-003", name: "鱸魚", allergen: "無" },
        { id: "2-01-0-001", name: "越光米", allergen: "無" },
        { id: "2-01-0-002", name: "牛番茄", allergen: "無" },
        { id: "2-01-0-003", name: "伊比利豬", allergen: "有" },
        { id: "2-01-0-001", name: "板腱牛", allergen: "無" },
      ],
    };
  },
  methods: {},
  components: { PageTitle }
};
</script>

<style lang="scss">
// @import 'bootstrap/dist/css/bootstrap.min.css';
// @import '@/assets/scss/all.scss';
@import "@/assets/scss/page/ingredients.scss";
</style>
