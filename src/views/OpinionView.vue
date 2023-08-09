<template>
    <!-- {{ opinionData }} -->
    <PageTitle :title="'烹飪心得管理'" />
    <div class="container">
        <div class="row">
            <!-- 搜尋框 -->
            <div class="col-3">
                <div class="input-group">
                    <span class="input-group-text">搜尋菜色</span>
                    <input type="text" class="form-control" placeholder="請輸入菜色" @input="searchIdOrPhone"
                        v-model="searchInput" />
                </div>
            </div>
        </div>
    </div>
    <!-- 頁碼 -->
    <PageComponent :data="searchResult" @changePage="getPageData" />
    <!-- 表格 -->
    <table class="table">
        <thead>
            <tr>
                <th scope="col" v-for="(item, index) in colTitle" :key="index">{{ item }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, index) in opinionData" :key="index">
                <td>{{ item.opinion_no }}</td>
                <td>{{ item.member }}</td>
                <td>{{ item.opinion_no_pic }}</td>
                <td>{{ truncateText(item.experience, 6) }}</td>
                <td>{{ item.share_time }}</td>
                <td>{{ item.state }}</td>
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
</template>
<script>
import PageTitle from '@/components/PageTitle.vue';
import PageComponent from '@/components/PageComponent.vue';

export default {
    name: 'IngredientView',
    component: {
        PageTitle,
        PageComponent,
    },
    data() {
        return {
            colTitle: ["會員編號", "食譜標題", "照片", "評論", "日期", "狀態",  "",  ""],
            opinionData: [
            ],
            searchResult: [],
            showData: [],
        };
    },
    methods: {
        getopinionData() {
            let url = `${this.$url}opinion.php`
            this.axios.get(url).then(res => {
                this.opinionData = res.data
            }).catch(err => {
                console.log(err);
            })
        },
        searchIdOrPhone() {
            console.log('type')
            if (this.searchInput == '') {
                this.searchResult = this.opinionData;
            } else {
                let idResult = this.opinionData.filter(item => {
                    return item.recipe.includes(this.searchInput);
                });
                console.log(idResult)
                if (idResult.length > 0) {
                    this.searchResult = idResult
                }
            }
        },
        getPageData(data) {
            this.showData = data
        },
        //控制顯示字數 多的用"..."省略
        truncateText(text) {
            if (text && text.length > 10) {
                return text.slice(0, 10) + '...';
            }
            return text;
        },
    },
    created() {
        this.searchResult = this.opinionData;
    },
    mounted() {
        this.getopinionData()
    },
    components: { PageTitle }
};
</script>

<style lang="scss">
@import "@/assets/scss/page/ingredients.scss";
</style>
