<template>
    <PageTitle :title="'烹飪心得管理'" />
    <div class="container">
        <div class="row">
            <!-- 搜尋框 -->
            <div class="col-3">
                <div class="input-group">
                    <span class="input-group-text">搜尋菜色</span>
                    <input type="text" class="form-control" placeholder="請輸入菜色" @input="searchIdOrPhone" v-model="searchInput"/>
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
            <tr v-for="(item, index) in searchResult" :key="index">
                <td>{{ item.id }}</td>
                <td>{{ item.recipe }}</td>
                <td>{{ item.pic }}</td>
                <td>{{ truncateText(item.comment, 6) }}</td>
                <td>{{ item.date }}</td>
                <td>{{ item.state }}</td>
                <td>{{ item.report }}</td>
                <td>
                    <button class="btn btn-outline-primary btn-sm">刪除</button>
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
    <!-- 頁碼 -->
    <PageComponent :data="searchResult" @changePage="getPageData"/>
</template>
<script>
import PageComponent from '@/components/PageComponent.vue';
import PageTitle from '@/components/PageTitle.vue';

// import PageComponent from "@/components/PageComponent.vue";
export default {
    name: 'IngredientView',
    component: {
        // PageComponent,
        PageTitle,
        PageComponent
    },
    data() {
        return {
            colTitle: ["會員編號", "食譜標題", "照片", "評論", "日期", "狀態", "檢舉",""],
            foodData: [
                { id: "1", recipe: "綠咖哩", pic: "s1.jpg", comment: "我就說這道菜很屌~", date: "2023/5/12",state:"上架",report:"套用",},
                { id: "2", recipe: "綠咖哩", pic: "s2.jpg", comment: "今天翹課坐火車回家，就是為了媽媽煮的這道菜！", date: "2023/5/12",state:"上架",report:"套用",},
                { id: "3", recipe: "綠咖哩", pic: "s3.jpg", comment: "住太遠uber送不到，只好自己在家做了。", date: "2023/5/12",state:"上架",report:"套用",},
                { id: "4", recipe: "綠咖哩", pic: "s3.jpg", comment: "覺得好吃的舉手~", date: "2023/5/12",state:"上架",report:"套用",},
                { id: "5", recipe: "綠咖哩", pic: "s1.jpg", comment: "剛從美國釣到的鮮魚，拿來做菜最適合", date: "2023/5/12",state:"上架",report:"套用",},
                { id: "6", recipe: "綠咖哩", pic: "s5.jpg", comment: "看到檸檬葉要怎麼樣~馬上做成綠咖哩", date: "2023/5/12",state:"上架",report:"套用",},
                { id: "7", recipe: "綠咖哩", pic: "s6.jpg", comment: "做到第幾道菜了?", date: "2023/5/12",state:"上架",report:"套用",},
                { id: "8", recipe: "綠咖哩", pic: "s1.jpg", comment: "感謝分享~~", date: "2023/5/12",state:"上架",report:"套用",},
                { id: "9", recipe: "綠咖哩", pic: "s2.jpg", comment: "綠咖哩中加入椰奶可以平衡辣味~", date: "2023/5/12",state:"上架",report:"套用",},
                { id: "10", recipe: "111", pic: "s3.jpg", comment: "如果你喜歡海鮮，將鮮蝦或魚片加入綠咖哩中，可以有豐富的海鮮風味，讓整道菜更好吃。", date: "2023/5/12",state:"上架",report:"套用",},
            ],
            searchResult: [],
            showData: [],
        };
    },
    methods: {
    searchIdOrPhone() {
        console.log('type')
      if (this.searchInput == '') {
        this.searchResult = this.foodData;
      } else {
        let idResult = this.foodData.filter(item => {
          return item.recipe.includes(this.searchInput);
        });
        console.log(idResult)
        if (idResult.length > 0) {
                this.searchResult = idResult
        }
      }
    },

    truncateText(text, length) {
      if (text.length > length) {
        return text.slice(0, length) + '...';
      }
      return text;
    },
},
    created() {
        this.searchResult = this.foodData;
    },
    components: { PageTitle }
};
</script>

<style lang="scss">
// @import 'bootstrap/dist/css/bootstrap.min.css';
// @import '@/assets/scss/all.scss';
@import "@/assets/scss/page/ingredients.scss";
</style>
