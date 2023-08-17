<template>
    <PageTitle :title="'訂單管理'" />
    <div class="container">
        <div class="row">
            <!-- 搜尋框 -->
            <div class="col-3" style="width: 350px;">
                <div class="input-group mb-3">
                    <span class="input-group-text">訂單編號</span>
                    <input type="text" class="form-control" style="width: 100px;" placeholder="搜尋" @input="searchOrdNo"
                        v-model="searchInput" />
                </div>
            </div>
            <div class="btn-group" style="width: 150px;padding: 10px;">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="defaultDropdown"
                    data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                    {{ selectedStatus ? selectedStatus : '訂單狀態' }}
                </button>
                <ul class="dropdown-menu" aria-labelledby="defaultDropdown">
                    <li><a class="dropdown-item" @click="selectedStatus = '處理中'">處理中</a></li>
                    <li><a class="dropdown-item" @click="selectedStatus = '配送中'">配送中</a></li>
                    <li><a class="dropdown-item" @click="selectedStatus = '已完成'">已完成</a></li>
                    <li><a class="dropdown-item" @click="selectedStatus = '已取消'">已取消</a></li>
                    <li><a class="dropdown-item" @click="selectedStatus = ''">顯示全部</a></li>
                </ul>
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
            <tr v-for="(item, index) in filteredData" :key="index">
                <td>{{ item.ord_date }}</td>
                <td>{{ parseInt(item.ord_no) + 2000 }}</td>
                <td>{{ item.cus_name }}</td>
                <td>{{ item.cus_email }}</td>
                <td>{{ item.total_price }}</td>
                <td>{{ item.payment }}</td>
                <td>{{ item.ord_status }}</td>
                <td><button class="btn btn-outline-primary btn-sm" @click="goOrderDetail(item.ord_no)">查閱</button></td>
            </tr>
        </tbody>
    </table>
    <!-- 頁碼 -->
    <PageComponent :data="searchResult" @changePage="getPageData" />
</template>
<script>
import PageComponent from '@/components/PageComponent.vue';
import PageTitle from '@/components/PageTitle.vue';

// import PageComponent from "@/components/PageComponent.vue";
export default {
    name: 'IngredientView',
    components: {
        PageComponent,
        PageTitle,

    },
    data() {
        return {
            searchInput: '',
            colTitle: ["訂單日期", "訂單編號", "會員姓名", "會員信箱", "訂單金額", "付款方式", "訂單狀態", ""],
            orderData: [],
            searchResult: [],
            showData: [],
            selectedStatus: '',
        };
    },
    computed: {
        filteredData() {
            if (this.selectedStatus === '') {
                return this.searchResult;
            } else {
                return this.searchResult.filter(item => item.ord_status === this.selectedStatus);
            }
        }
    },

    methods: {
        getOrderData() {
            let url = `${this.$url}orderRows.php`
            this.axios.get(url).then(res => {
                console.log(res.data)
                this.orderData = res.data
            }).catch(err => {
                console.log(err);
            })
        },

        searchOrdNo() {
            console.log(this.searchInput);
            if (this.searchInput == "") {
                this.searchResult = this.orderData;
            } else {
                let idResult = this.orderData.filter((item) => {
                    // return item.ord_no.includes(this.searchInput);
                    return item.ord_no.toString().includes(this.searchInput);
                });
                this.searchResult = idResult;
            }
        },

        getPageData(data) {
            this.showData = data
        },
        goOrderDetail(ord_no) {
            sessionStorage.setItem('ord_no',ord_no);
            let url = `${this.$url}orderDetail.php`
            let params = new URLSearchParams()
            params.append("ordNo", ord_no)
            this.axios.post(url, params).then(res => {
                console.log(res.data)
                console.log(typeof res.data)
                this.$store.commit('sendOrdDetail', res.data);
                this.$router.push('/ordDetail');
            }).catch(err => {
                console.log(err);
            })
        }
    },
    watch: {
        orderData: {
            handler: function () {
                this.searchResult = this.orderData
            },
            deep: true
        },
    },
    mounted() {
        this.getOrderData();
    },
};
</script>

<style lang="scss">
// @import 'bootstrap/dist/css/bootstrap.min.css';
// @import '@/assets/scss/all.scss';
@import "@/assets/scss/page/ingredients.scss";
</style>
