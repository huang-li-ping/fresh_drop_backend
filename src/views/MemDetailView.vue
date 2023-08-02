<template>
    <PageTitle :title="'會員資料明細'">
        <template v-slot:button>
            <div class="btn btn-outline-primary rounded-pill">返回</div>
            
        </template>
    </PageTitle>
    
    <div class="mem_detail_container">
        <div class="info_group row">
            <div class="col-3">
                <p>會員姓名：{{memInfo.name}}</p>
            </div>
            <div class="col-3">
                <p>會員編號：{{ memInfo.no }}</p>
            </div>
            <div class="col-3">
                <p>會員生日：{{ memInfo.birth }}</p>
            </div>
            <div class="col-3">
                <p>手機號碼：{{ memInfo.phone }}</p>
            </div>
            <div class="col-4">
                <p>會員信箱：{{ memInfo.email }}</p>
            </div>
        </div>
        <div class="shop_gift_wrap">
            <div class="shop_history">
                <h6>歷史訂單</h6>
                <hr>
                <!-- 表格 -->
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th v-for="(item, index) in shopHistoryTh" :key="index">{{ item }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in shopHistoryList" :key="index">
                            <td>{{ item.date }}</td>
                            <td>{{ item.number }}</td>
                            <td>{{ item.status }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary rounded-pill">查閱</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="gift_history">
                <h6>禮物卡明細</h6>
                <hr>
                <!-- 表格 -->
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th v-for="(item, index) in giftHistoryTh" :key="index">{{ item }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in giftHistoryList" :key="index">
                            <td>{{ item.no }}</td>
                            <td>{{ item.remain }}</td>
                            <td>{{ item.date }}</td>
                            <td>{{ item.giver }}</td>
                            
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
            memInfo: {
                name: '王大廷',
                no: 123654,
                birth: '1994-05-26',
                phone: '0952-099091',
                email: 'freahdrop@gmail.com',
            },
            shopHistoryTh:['訂單日期', '訂單編號', '訂單狀態', ''],
            giftHistoryTh: ['禮物卡編號', '餘額', '收到日期', '寄送者'],
            shopHistoryList: [
                {
                    date: '2023-07-01',
                    number: '12345678',
                    status: '配送中'
                },
                {
                    date: '2023-06-23',
                    number: '87654321',
                    status: '已送達'
                },
                {
                    date: '2023-06-16',
                    number: '65498732',
                    status: '已送達'
                },
                {
                    date: '2023-06-09',
                    number: '32165478',
                    status: '已送達'
                },
                {
                    date: '2023-06-02',
                    number: '98712365',
                    status: '已送達'
                },
            ],
            giftHistoryList: [
                {
                    no: 12365498,
                    remain: 1000,
                    date: '2023-07-31',
                    giver: '林小慧'
                },
                {
                    no: 65498732,
                    remain: 0,
                    date: '2023-02-14',
                    giver: '林小慧'
                },
                {
                    no: 98453298,
                    remain: 0,
                    date: '2022-12-25',
                    giver: '林小慧'
                },
                {
                    no: 12657845,
                    remain: 0,
                    date: '2022-07-31',
                    giver: '林小慧'
                },
            ],
        };
    },
    methods: {},
    created() {},
};
</script>

<style lang="scss">
@import "@/assets/scss/page/memDetail.scss";
</style>
