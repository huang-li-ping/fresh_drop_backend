<template>
    <PageTitle :title="'訂單管理'" />
    <div class="container">
        <div class="row">
            <!-- 搜尋框 -->
            <div class="col-3" style="width: 350px;">
                <div class="input-group mb-3">
                    <span class="input-group-text">訂單編號</span>
                    <input type="text" class="form-control" style="width: 100px;" placeholder="搜尋" />
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" type="button" style="margin-left: 10px">search</button>
                    </div>
                </div>
            </div>
            <div class="btn-group" style="width: 150px;padding: 10px;">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="defaultDropdown"
                    data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                    訂單狀態
                </button>
                <ul class="dropdown-menu" aria-labelledby="defaultDropdown">
                    <li><a class="dropdown-item" href="#">處理中</a></li>
                    <li><a class="dropdown-item" href="#">已完成</a></li>
                    <li><a class="dropdown-item" href="#">訂單取消</a></li>
                </ul>
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
                <!-- <td>
                    <button class="edit-button btn btn-sm btn-outline-secondary rounded-5">
                        <font-awesome-icon icon="fa-solid fa-pen" />
                    </button>
                </td> -->
                <td>{{ item.ord_date }}</td>
                <td>{{ item.ord_no }}</td>
                <td>{{ item.name }}</td>
                <td>{{ item.email }}</td>
                <td>{{ item.total }}</td>
                <td>{{ item.payment }}</td>
                <td>{{ item.status }}</td>
                <td><button class="btn btn-outline-primary btn-sm">查閱</button></td>
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
            colTitle: ["訂單日期", "訂單編號", "會員姓名", "會員信箱", "訂單金額", "付款方式", "訂單狀態", ""],
            foodData: [
                { ord_date: "2023-07-02", ord_no: "WEE5YDGRQ", name: "蔡宗驊", email: "abc123@gmail.com", total: "$3680", payment: "信用卡+禮物卡", status: "處理中" },
                { ord_date: "2023-07-02", ord_no: "WEE5YDGRQ", name: "黃莉萍", email: "abc123@gmail.com", total: "$680", payment: "ATM匯款", status: "訂單取消" },
                { ord_date: "2023-07-02", ord_no: "WEE5YDGRQ", name: "李岱霖", email: "abc123@gmail.com", total: "$680", payment: "信用卡", status: "處理中" },
                { ord_date: "2023-07-02", ord_no: "WEE5YDGRQ", name: "江瑀庭", email: "abc123@gmail.com", total: "$480", payment: "信用卡", status: "訂單取消" },
                { ord_date: "2023-07-02", ord_no: "WEE5YDGRQ", name: "許弘毅", email: "abc123@gmail.com", total: "$1080", payment: "信用卡+禮物卡", status: "已完成" },
                { ord_date: "2023-07-02", ord_no: "WEE5YDGRQ", name: "徐億籃", email: "abc123@gmail.com", total: "$880", payment: "禮物卡", status: "已完成" },
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
