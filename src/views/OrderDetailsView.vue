<template>
    <PageTitle :title="'訂單管理 / 訂單明細'" />

    <!-- 表格 -->
    <div class="details_container">
        <div class="top" style="display: flex;">
            <div class="date">
                <p>訂單日期：<span>{{ order.ord_date }}</span></p>
            </div>
            <div class="ord_number">
                <p>訂單編號：<span>{{ order.ord_no }}</span></p>
            </div>
            <div class="mem_name">
                <p>會員姓名：<span>{{ order.mem_name }}</span></p>
            </div>
            <div class="deliv_no">
                <p>訂購方案：<span>{{ order.deliv_no }}</span></p>
            </div>
        </div>
        <div class="between" style="display: flex;">
            <div class="total">
                <p>訂單金額：<span>{{ order.total }}</span></p>
            </div>
            <div class="payment">
                <p>付款方式：<span>{{ order.payment }}</span></p>
            </div>
            <div class="ord_status">
                <p>訂單狀態：<span>{{ order.ord_status }}</span></p>
            </div>
            <div class="week">
                <p>出貨狀態：<span>{{ order.deliv_status }}</span></p>
            </div>
        </div>
        <div class="bottom" style="display: flex;">
            <div class="cus_name">
                <p>收件人姓名：<span>{{ order.cus_name }}</span></p>
            </div>
            <div class="cus_phone">
                <p>收件人電話：<span>{{ order.cus_phone }}</span></p>
            </div>
            <div class="cus_add">
                <p>收件地址：<span>{{ order.cus_add }}</span></p>
            </div>
        </div>
    </div>
    <div class="ord_details col-6 " style="margin: 20px 20px 0 20px;">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" :class="{ active: currentTab === 'WEEK1' }" @click="currentTab = 'WEEK1'" href="#">
                    WEEK1
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" :class="{ active: currentTab === 'WEEK2' }" @click="currentTab = 'WEEK2'" href="#">
                    WEEK2
                </a>
            </li>
        </ul>
    </div>
    <div v-if="currentTab === 'WEEK1'" class="col-6">
        <!-- WEEK1的内容 -->
        <table class="table" style="border: solid 1px #1F8D61;margin: 0 20px;">
            <thead>
                <tr>
                    <th scope="col" v-for="(item, index) in colTitle" :key="index">{{ item }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in week1Data" :key="index">
                    <td>{{ item.recipe }}</td>
                    <td>{{ item.qty }}</td>
                    <td>{{ item.status }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div v-else-if="currentTab === 'WEEK2'" class="col-6">
        <!-- WEEK2的内容 -->
        <table class="table" style="border: solid 1px #1F8D61;margin: 0 20px;">
            <thead>
                <tr>
                    <th scope="col" v-for="(item, index) in colTitle" :key="index">{{ item }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in week2Data" :key="index">
                    <td>{{ item.recipe }}</td>
                    <td>{{ item.qty }}</td>
                    <td>{{ item.status }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="bill_container">
        <table class="table" style="border: solid 1px #1F8D61;margin: 0 20px;">
            <thead>
                <tr>
                    <th scope="col" v-for="(item, index) in bilTitle" :key="index">{{ item }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in foodData" :key="index">
                    <td>{{ item.ord_date }}</td>
                    <td>{{ item.ord_no }}</td>
                </tr>
            </tbody>
        </table>
    </div>
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
            order:
            {
                ord_date: "2023-07-02",
                ord_no: "WEE5YDGRQ",
                mem_name: "蔡宗驊",
                deliv_no: "定期配送",
                total: "$1680",
                payment: "信用卡+禮物卡",
                ord_status: "處理中",
                deliv_status: "WEEK1",
                cus_name: "江瑀庭",
                cus_phone: "0933-099932",
                cus_add: "320 桃園市中壢區復興路46號",
                email: "abc123@gmail.com",
            },
            currentTab: 'WEEK1',
            colTitle: ["品項", "份數", "出貨狀態",],
            week1Data: [
                { recipe: "滑嫩蕃茄蛋", qty: "X1", status: "已出貨\n(2023-07-05)" },
                { recipe: "蒸蛋", qty: "X1", },
                { recipe: "味噌鮮魚湯", qty: "X1", },
                { recipe: "塔香茄子", qty: "X1", },
            ],
            week2Data: [
                { recipe: "越南河粉湯", qty: "X1", status: "處理中" },
                { recipe: "泰式生菜包", qty: "X1", },
                { recipe: "麻婆豆腐", qty: "X1", },
                { recipe: "巴西凱撒沙拉", qty: "X1", },
            ],
            bilTitle: ["訂單金額明細",],
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

.details_container {
    p {
        margin: 10px;
    }

    span {
        padding: 5px 10px;
        border: solid 1px;
        border-radius: $m-br;
    }
}
</style>
