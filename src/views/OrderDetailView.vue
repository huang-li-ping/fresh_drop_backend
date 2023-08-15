<template>
    <PageTitle :title="'訂單管理 / 訂單明細'" />

    <!-- 表格 -->
    <div class="details_container">
        <div class="top" style="display: flex;" v-if="orderInfo">
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
        <div class="between" style="display: flex;" v-if="orderInfo">
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
        <div class="bottom" style="display: flex;" v-if="orderInfo">

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
            <div class="ord_details" style="display: flex;" v-if="orderList">
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
                <tbody v-if="orderList">
                    <tr v-for="(item, index) in currentData" :key="index">
                        <td>{{ item.recipe }}</td>
                        <td>{{ item.qty }}</td>
                        <td>{{ item.status }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="bill_container" v-if="orderList">
            <p>訂單金額明細</p>
            <div class="frist">
                <p v-if="orderList.length > 1">${{ orderList.length * 200 }}/週</p>
                <p>X{{ orderList.length }}</p>
                <p v-if="orderList.length = 1">金額：${{ orderInfo.ord_price - 80 }}</p>
                <p v-if="orderList.length > 1">金額：${{ (orderInfo.ord_price - 80) / 0.8 }}</p>
            </div>
            <p style="text-align: right;" v-if="orderList.length > 1">優惠折抵：${{ (orderInfo.ord_price - 80) / 0.2 }}</p>
            <p style="text-align: right;">運費:$80</p>
            <p style="text-align: right;" v-if="orderInfo.discount_price > 0">禮物卡折抵：${{ orderInfo.discount_price }}</p>
            <!-- <p style="text-align: right;" v-if="orderInfo.discount_price > 0">{{ orderInfo.discount_price }}</p> -->
            <hr>
            <p style="text-align: right;">{{ orderInfo.total_price }}</p>
        </div>
    </div>
</template>
<script>
import PageTitle from '@/components/PageTitle.vue';
import axios from 'axios';
export default {
    name: 'IngredientView',
    components: {
        PageTitle,
    },
    data() {
        return {
            orderInfo: null,
            orderList: null,
            currentData: [],

            currentTab: 1,
            colTitle: ["品項", "份數", "出貨狀態",],
        };
    },
    methods: {
        showCurrentData(n) {
            this.currentData = this.orderList[n - 1];
        },
        async fetchOrderDetail(ordNo) {
            if (ordNo) {
                let url = `${this.$url}ordDetail.php`;
                try {
                    const response = await axios.post(url, { ordNo });
                    this.orderInfo = response.data;
                console.log(response.data);
                } catch (error) {
                    console.error('Error fetching order detail:', error);
                }
            }
        },
    },
    mounted() {
        const ordNo = this.$route.params.ordNo;
        if (ordNo) {
            this.fetchOrderDetail(ordNo);
        }
        console.log(this.$store.state.ordDetail);
        this.orderList = this.$store.state.ordDetail.orderList
        this.orderInfo = this.$store.state.ordDetail.orderInfo
        this.showCurrentData(1);
    },
    watch: {
        "$store.state.ordDetail": {
            handler: function (newval) {
                console.log('watch triggered', newval);
                this.orderInfo = newval.orderInfo;
                this.orderList = newval.orderList
                this.showCurrentData(1);
            },
            deep: true,
        }
    },
};
</script>

<style lang="scss">
@import "@/assets/scss/page/ingredients.scss";

.details_container {
    p {
        margin: 10px 20px;
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
    width: 550px;
    margin: 0 20px;
}

.ord_details {
    margin: 20px 20px 0 0;
}
</style>
