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
    <div class="order_bottom" style="display: flex;">
        <div class="deatils_box">
            <div class="ord_details" style="display: flex;">
                <ul class="nav nav-tabs" v-show="orderList.length > 1">
                    <li class="nav-item" v-for="n in orderList.length" :key="n">
                        <a class="nav-link" :class="{ active: currentTab === 'WEEK1' }" @click="showCurrentData(n)"
                            href="#">
                            WEEK{{ n }}
                        </a>
                    </li>
                </ul>
            </div>
            <!-- <div v-if="currentTab === 'WEEK1'"> -->
            <!-- WEEK1的内容 -->
            <table class="table" style="border: solid 1px #1F8D61;">
                <thead>
                    <tr>
                        <th scope="col" v-for="(item, index) in colTitle" :key="index">{{ item }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in currentData" :key="index">
                        <td>{{ item.recipe }}</td>
                        <td>{{ item.qty }}</td>
                        <td>{{ item.status }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="bill_container">
            <p>訂單金額明細</p>
            <div class="frist">
                <p>{{ billDetails.week }}</p>
                <p>{{ billDetails.qty }}</p>
                <P>{{ billDetails.amount }}</P>
            </div>
            <p style="text-align: right;">{{ billDetails.deliv_m }}</p>
            <p style="text-align: right;">{{ billDetails.giftcard_m }}</p>
            <p style="text-align: right;">{{ billDetails.giftcard_n }}</p>
            <hr>
            <p style="text-align: right;">{{ billDetails.total }}</p>
        </div>
    </div>
</template>
<script>
import PageTitle from '@/components/PageTitle.vue';

export default {
    name: 'IngredientView',
    component: {
        PageTitle,
    },
    data() {
        return {
            order:
            {
                ord_date: "2023-07-02",
                ord_no: "1",
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
                ord_credit_no: "1234-1234-1234-1234",
            },
            currentTab: 1,
            colTitle: ["品項", "份數", "出貨狀態",],
            currentData: {},
            orderList: [
                [
                    { recipe: "滑嫩蕃茄蛋", qty: "X1", status: "已出貨\n(2023-07-05)" },
                    { recipe: "蒸蛋", qty: "X1", },
                    { recipe: "味噌鮮魚湯", qty: "X1", },
                    { recipe: "塔香茄子", qty: "X1", },
                ],
                [
                    { recipe: "越南河粉湯", qty: "X1", status: "處理中" },
                    { recipe: "泰式生菜包", qty: "X1", },
                    { recipe: "麻婆豆腐", qty: "X1", },
                    { recipe: "巴西凱撒沙拉", qty: "X1", },
                ],
            ],
            billDetails: {
                week: "$800 /週",
                qty: "X2",
                amount: "金額：$1600",
                deliv_m: "運費：$80",
                giftcard_m: "禮物卡折抵：-$100",
                giftcard_n: "禮物卡編號：01234567",
                total: "總金額：$1580",
            }
        };
    },
    methods: {
        showCurrentData(n) {
            // this.currentData = this.orderList[this.currentTab-1]
            this.currentData = this.orderList[n - 1];
        }
    },
    mounted() {
        this.showCurrentData(1);
    },
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

.frist {
    display: flex;
    justify-content: space-between;
}

.bill_container {
    border: solid 1px #1F8D61;
    border-radius: $s-br;
    margin: 50px 20px;
    width: 450px;
    padding: 20px;
}

.deatils_box {
    width: 350px;
    margin: 0 20px;
}

.ord_details {
    margin: 20px 20px 0 0;
}
</style>
