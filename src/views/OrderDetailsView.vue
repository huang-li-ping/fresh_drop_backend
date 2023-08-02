<template>
    <PageTitle :title="'訂單管理 / 訂單明細'" />

    <!-- 表格 -->
    <div class="details_container">
        <div class="top" style="display: flex;">
            <div class="date">
                <p>訂單日期：{{ order.ord_date }}</p>
            </div>
            <div class="ord_number">
                <p>訂單編號：{{ order.ord_no }}</p>
            </div>
            <div class="mem_name">
                <p>會員姓名：{{ order.mem_name }}</p>
            </div>
            <div class="deliv_no">
                <p>訂購方案：{{ order.deliv_no }}</p>
            </div>
        </div>
        <div class="between" style="display: flex;">
            <div class="total">
                <p>訂單金額：{{ order.total }}</p>
            </div>
            <div class="payment">
                <p>付款方式：{{ order.payment }}</p>
            </div>
            <div class="ord_status">
                <p>訂單狀態：{{ order.ord_status }}</p>
            </div>
            <div class="week">
                <p>出貨狀態：{{  }}</p>
            </div>
        </div>
        <div class="bottom" style="display: flex;">
            <div class="cus_name">
                <p>收件人姓名：{{  }}</p>
            </div>
            <div class="cus_phone">
                <p>收件人電話：{{  }}</p>
            </div>
            <div class="cus_add">
                <p>收件地址：{{  }}</p>
            </div>
        </div>
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
                { ord_date: "2023-07-02", ord_no: "WEE5YDGRQ", mem_name: "蔡宗驊", deliv_no:"定期配送",total: "$3680",payment: "信用卡+禮物卡",email: "abc123@gmail.com",   status: "處理中" },
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
