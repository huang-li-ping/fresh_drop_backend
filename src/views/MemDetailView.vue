<template>
    <PageTitle :title="'會員資料明細'">
        <template v-slot:button>
            <div class="btn btn-outline-primary rounded-pill" @click="$router.go(-1)">返回</div>
        </template>
    </PageTitle>

    <div class="mem_detail_container">
        <div class="info_group row">
            <div class="col-3">
                <p>會員姓名：{{ memInfo.cus_name }}</p>
            </div>
            <div class="col-3">
                <p>會員編號：{{ parseInt(memInfo.cus_no) + 1000 }}</p>
            </div>
            <div class="col-3">
                <p>會員生日：{{ memInfo.birth }}</p>
            </div>
            <div class="col-3">
                <p>手機號碼：{{ memInfo.phone }}</p>
            </div>
            <div class="col-6">
                <p>會員信箱：{{ memInfo.cus_email }}</p>
            </div>
        </div>
        <div class="shop_gift_wrap">
            <div class="shop_history">
                <h6>歷史訂單</h6>
                <hr />
                <!-- 表格 -->
                <table class="table"  :class="{'table-hover':shopHistoryList.length > 0}">
                    <thead>
                        <tr>
                            <th v-for="(item, index) in shopHistoryTh" :key="index">{{ item }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in shopHistoryList" :key="index">
                            <td>{{ item.ord_date }}</td>
                            <td>{{ parseInt(item.ord_no) + 2000 }}</td>
                            <td>{{ item.ord_status }}</td>
                            <td>
                                <button class="btn btn-outline-primary rounded-pill"
                                    @click.prevent="showOrderDetail(item.number)">查閱</button>
                            </td>
                        </tr>
                        <tr colspan="4" v-if="shopHistoryList.length == 0">
                            <td colspan="4">無訂單資料</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="gift_history">
                <h6>禮物卡明細</h6>
                <hr />
                <!-- 表格 -->
                <table class="table" :class="{'table-hover':giftHistoryList.length > 0}">
                    <thead>
                        <tr>
                            <th v-for="(item, index) in giftHistoryTh" :key="index">{{ item }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in giftHistoryList" :key="index">
                            <td>{{ parseInt(item.giftcard_no) + 3000 }}</td>
                            <td>${{ item.giftcard_balance }}</td>
                            <td>{{ item.giftcard_purchase_date }}</td>
                            <td>{{ item.giver_name}}</td>
                        </tr>
                        <tr colspan="4" v-if="giftHistoryList.length == 0">
                            <td colspan="4">無訂單資料</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
import PageTitle from "@/components/PageTitle.vue";

export default {
    name: "MemDetailView",
    components: {
        PageTitle,
    },
    data() {
        return {
            memInfo: {},
            shopHistoryTh: ["訂單日期", "訂單編號", "訂單狀態", ""],
            giftHistoryTh: ["禮物卡編號", "餘額", "收到日期", "寄送者"],
            shopHistoryList: [],
            giftHistoryList: [],
        };
    },
    methods: {
        async sessionCusNo() {
            let id = await sessionStorage.getItem("detail_cusNo");
            if (id) {
                let url = `${this.$url}memberDetail.php`;
                let params = new URLSearchParams();
                params.append("cusNo", id);
                this.axios
                    .post(url, params)
                    .then((res) => {
                        this.$store.commit("sendMemDetail", res.data);
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            } else { 
                this.$router.push('/member')
            }
        },
        showOrderDetail(ordNo) {
            console.log(ordNo);
            // this.$router.push('/ordDeatil')
        },
    },
    watch: {
        '$store.state.memDetail': {
            handler: function (newval) {
            this.memInfo = newval[0]
            this.shopHistoryList = newval[1];
            this.giftHistoryList = newval[2];
            },
            deep: true,
        }
    },
    mounted() {
        this.sessionCusNo();
    },
};
</script>

<style lang="scss">
@import "@/assets/scss/page/memDetail.scss";
</style>
