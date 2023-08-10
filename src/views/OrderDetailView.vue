<template>
    <PageTitle :title="'訂單管理 / 訂單明細'" />

    <!-- 表格 -->
    <div class="details_container">
        <div class="top" style="display: flex;">
            <div class="date">
                <p>訂單日期：<span>{{ orderInfo.ord_date }}</span></p>
            </div>
            <div class="ord_number">
                <p>訂單編號：<span>{{ parseInt(orderInfo.ord_no) + 2000 }}</span></p>
            </div>
            <div class="cus_name">
                <p>會員姓名：<span>{{ orderInfo.cus_name }}</span></p>
            </div>
            <div class="cus_name">
                <p>會員信箱：<span>{{ orderInfo.cus_email }}</span></p>
            </div>
        </div>
        <div class="between" style="display: flex;">
            <div class="total">
                <p>訂單金額：<span>{{ orderInfo.total_price }}</span></p>
            </div>
            <div class="payment">
                <p>付款方式：<span>{{ orderInfo.payment }}</span></p>
            </div>
            <div class="ord_status">
                <p>訂單狀態：<span>{{ orderInfo.ord_status }}</span></p>
            </div>
            <div class="week">
                <p>出貨狀態：<span>{{ orderInfo.week }}</span></p>
            </div>
        </div>
        <div class="bottom" style="display: flex;">

            <div class="ord_cus">
                <p>收件人姓名：<span>{{ orderInfo.ord_cus }}</span></p>
            </div>
            <div class="cus_phone">
                <p>收件人電話：<span>{{ orderInfo.ord_phone }}</span></p>
            </div>
            <div class="cus_add">
                <p>收件地址：<span>{{ orderInfo.ord_addr }}</span></p>
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
                <p>{{ billDetail.week }}</p>
                <p>{{ billDetail.qty }}</p>
                <P>{{ billDetail.amount }}</P>
            </div>
            <p style="text-align: right;">{{ billDetail.deliv_m }}</p>
            <p style="text-align: right;">{{ billDetail.giftcard_m }}</p>
            <p style="text-align: right;">{{ billDetail.giftcard_n }}</p>
            <hr>
            <p style="text-align: right;">{{ billDetail.total }}</p>
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
            orderInfo: {},
            // orderInfo:
            // {
            //     ord_date: "2023-07-02",
            //     ord_no: "1",
            //     cus_name: "蔡宗驊",
            //     cus_email:"Andy_Evans@freshdrop.com",
            //     deliv_no: "定期配送",
            //     total_price: "$1680",
            //     payment: "信用卡+禮物卡",
            //     ord_status: "處理中",
            //     week: "WEEK1",
            //     ord_cus: "江瑀庭",
            //     ord_phone: "0933-099932",
            //     ord_addr: "320 桃園市中壢區復興路46號",
            //     ord_credit_no: "1234-1234-1234-1234",
            // },

            currentTab: 1,
            colTitle: ["品項", "份數", "出貨狀態",],
            currentData: {},
            orderList: [
                [],
                [],
                [],
                [],
            ],
            
            // orderList: [
            //     [
            //         { recipe: "滑嫩蕃茄蛋", qty: "X1", status: "已出貨(2023-07-05)" },
            //         { recipe: "蒸蛋", qty: "X1", },
            //         { recipe: "味噌鮮魚湯", qty: "X1", },
            //         { recipe: "塔香茄子", qty: "X1", },
            //     ],
            //     [
            //         { recipe: "越南河粉湯", qty: "X1", status: "處理中" },
            //         { recipe: "泰式生菜包", qty: "X1", },
            //         { recipe: "麻婆豆腐", qty: "X1", },
            //         { recipe: "巴西凱撒沙拉", qty: "X1", },
            //     ],
            // ],
            billDetail: {},
            // billDetail: {
            //     week: "$800 /週",
            //     qty: "X2",
            //     amount: "金額：$1600",
            //     deliv_m: "運費：$80",
            //     giftcard_m: "禮物卡折抵：-$100",
            //     giftcard_n: "禮物卡編號：01234567",
            //     total: "總金額：$1580",
            // }
        };
    },
    methods: {
        showCurrentData(n) {
            this.currentData = this.orderList[n - 1];
        },
        async fetchOrderDetail(ordNo) {
            try {
                const response = await axios.post('orderDetail.php', { ordNo });
                this.orderInfo = response.data;
            } catch (error) {
                console.error(error);
            }
        },
        // async sessionOrdNo(orderNoParam) {
        //     if (orderNoParam) {
        //         let url = `${this.$url}ordDetail.php`;
        //         let params = new URLSearchParams();
        //         params.append("ordNo", orderNoParam);
        //         try {
        //             let response = await this.axios.post(url, params);
        //             this.orderInfo = response.data;
        //         } catch (error) {
        //             console.error(error);
        //         }
        //     } else {
        //         this.$router.push('/order');
        //     }
        // },

    },
    mounted() {
        this.showCurrentData(1);
        // this.sessionOrdNo(this.orderInfo.ord_no);
        const ordNo = this.$route.params.ordNo;
        this.fetchOrderDetail(ordNo);
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
        margin: 10px 5px;
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
