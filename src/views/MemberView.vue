<template>
    <PageTitle :title="'會員資料管理'" />
    <div class="member_container">
        <div class="mb-3 ps-3 pe-3 search_bar_group">
            <div class="d-flex justify-content-between">
                <div class="input-group">
                    <span class="input-group-text">搜尋會員</span>
                    <input type="text" class="form-control" placeholder="請輸入手機號碼或會員編號" @input="searchIdOrPhone" v-model="searchInput"/>
                </div>
                <div class="btn btn-outline-primary" @click="searchIdOrPhone">搜尋</div>
            </div>
        </div>
        <!-- 表格 -->
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="(item, index) in colTitle" :key="index">{{ item }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in showData" :key="index">
                    <td>{{ parseInt(item.cus_no) + 1000}}</td>
                    <td>{{ item.cus_name }}</td>
                    <td>{{ item.cus_email }}</td>
                    <td>{{ item.phone }}</td>
                    <td>{{ item.birth }}</td>
                    <td class="add_td">{{ item.address }}</td>
                    <td><button class="btn btn-outline-primary btn-sm" @click="goMemberDetail(item.cus_no);">查閱</button></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- 頁碼 -->
    <PageComponent :data="searchResult" @changePage="getPageData"/>
</template>
<script>
import PageComponent from '@/components/PageComponent.vue';
import PageTitle from '@/components/PageTitle.vue';

export default {
    name: "MemberView",
    components: {
    PageTitle,
    PageComponent
},
    data() {
        return {
            showData: [],
            searchInput: '',
            colTitle: ["會員編號", "會員名稱", "會員信箱", "手機號碼", "生日", "住址", ""],
            memData: [],
            searchResult: [],
        };
    },
    methods: {
        getMemData() {
            let url = `${this.$url}memberRows.php`
            this.axios.get(url).then(res => {
                res.data.forEach(item => {
                    if (item.phone.substr(4, 1) !== '-') {
                        if (item.phone.length == 10) { 
                            let front4 = item.phone.substr(0, 4)
                            let back6 = item.phone.substr(4, 6)
                            item.phone = front4.concat('-', back6)
                        }else if (item.phone.length !== 10) {
                            console.log(item.phone);
                        }
                    } 
                })
                this.memData = res.data
            }).catch(err => {
                console.log(err);
            })
        },
        searchIdOrPhone() {
            if (this.searchInput == "") {
                this.searchResult = this.memData;
            }
            let idResult = this.memData.filter((item) => {
                // return item.id.includes(this.searchInput)
                return item.cus_no.toString().includes(this.searchInput);
            });
            let phoneResult = this.memData.filter((item) => {
                // return item.phone.includes(this.searchInput)
                return item.phone.toString().includes(this.searchInput);
            });
            if (idResult.length > 0) {
                this.searchResult = idResult;
            } else if (phoneResult.length > 0) {
                this.searchResult = phoneResult;
            }
        },
        goMemberDetail(id) {
            let url = `${this.$url}memberDetail.php`
            let params = new URLSearchParams()
            params.append("cusNo", id)
            this.axios.post(url, params).then(res => {
                console.log(res.data)
                this.$store.commit('sendMemDetail', res.data);
                if (this.$route.path == '/member') {
                    this.$router.push('/memDetail')
                }
            }).catch(err => {
                console.log(err);
            })

        },
        getPageData(data) {
            this.showData = data
        },
    },
    watch: {
        memData: {
            handler: function () {
                this.searchResult = this.memData
            },
            deep:true
        },
    },
    mounted (){
        this.getMemData()
    },
};
</script>

<style lang="scss">
.member_container {
    .input-group {
        width: fit-content;
    }
    .add_td {
        max-width: 150px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
}
</style>
