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
                    <td>{{ item.id }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.email }}</td>
                    <td>{{ item.phone }}</td>
                    <td>{{ item.birth }}</td>
                    <td class="add_td">{{ item.add }}</td>
                    <td><button class="btn btn-outline-primary btn-sm">查閱</button></td>
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
            searchInput: '',
            colTitle: ["會員編號", "會員名稱", "會員信箱", "手機號碼", "生日", "住址", ""],
            memData: [
                {
                    id: "98765425",
                    name: "蔡宗驊",
                    email: "abc@gamil.com",
                    phone: "0913-986754",
                    birth: "1994-05-26",
                    add: "桃園市中壢區復興路48號8樓",
                },
                {
                    id: "98757322",
                    name: "熊毅",
                    email: "abc@gamil.com",
                    phone: "0987-987554",
                    birth: "1994-05-26",
                    add: "桃園市中壢區復興路48號8樓",
                },
                {
                    id: "98732586",
                    name: "徐億籃",
                    email: "abc@gamil.com",
                    phone: "0956-909854",
                    birth: "1994-05-26",
                    add: "桃園市中壢區復興路48號8樓",
                },
                {
                    id: "98768925",
                    name: "黃莉萍",
                    email: "abc@gamil.com",
                    phone: "0952-973454",
                    birth: "1994-05-26",
                    add: "桃園市中壢區復興路48號8樓",
                },
                {
                    id: "95609322",
                    name: "李岱霖",
                    email: "abc@gamil.com",
                    phone: "0952-123354",
                    birth: "1994-05-26",
                    add: "桃園市中壢區復興路48號8樓",
                },
                {
                    id: "98432586",
                    name: "江瑀庭",
                    email: "abc@gamil.com",
                    phone: "0952-909090",
                    birth: "1994-05-26",
                    add: "桃園市中壢區復興路48號8樓",
                },
                {
                    id: "98765425",
                    name: "蔡宗驊",
                    email: "abc@gamil.com",
                    phone: "0909-332876",
                    birth: "1994-05-26",
                    add: "桃園市中壢區復興路48號8樓",
                },
                {
                    id: "98753452",
                    name: "李岱霖",
                    email: "abc@gamil.com",
                    phone: "0919-202043",
                    birth: "1994-05-26",
                    add: "桃園市中壢區復興路48號8樓",
                },
                {
                    id: "09433586",
                    name: "江瑀庭",
                    email: "abc@gamil.com",
                    phone: "0930-808095",
                    birth: "1994-05-26",
                    add: "桃園市中壢區復興路48號8樓",
                },
                {
                    id: "98719325",
                    name: "徐億籃",
                    email: "abc@gamil.com",
                    phone: "0990-354667",
                    birth: "1994-05-26",
                    add: "桃園市中壢區復興路48號8樓",
                },
                {
                    id: "98432586",
                    name: "江瑀庭",
                    email: "abc@gamil.com",
                    phone: "0952-909090",
                    birth: "1994-05-26",
                    add: "桃園市中壢區復興路48號8樓",
                },
                {
                    id: "98765425",
                    name: "蔡宗驊",
                    email: "abc@gamil.com",
                    phone: "0909-332876",
                    birth: "1994-05-26",
                    add: "桃園市中壢區復興路48號8樓",
                },
                {
                    id: "98753452",
                    name: "李岱霖",
                    email: "abc@gamil.com",
                    phone: "0919-202043",
                    birth: "1994-05-26",
                    add: "桃園市中壢區復興路48號8樓",
                },
            ],
            searchResult: [],
            showData: [],
        };
    },
    methods: {
        searchIdOrPhone() {
            if (this.searchInput == '') {
                this.searchResult = this.memData
            }
            let idResult = this.memData.filter(item => {
                return item.id.includes(this.searchInput)
            })
            let phoneResult = this.memData.filter(item => {
                return item.phone.includes(this.searchInput)
            })
            if (idResult.length > 0) {
                this.searchResult = idResult
            } else if ((phoneResult.length > 0)) {
                this.searchResult = phoneResult
            }
        },
        getPageData(data) {
            this.showData = data
        },
    },
    created (){
        this.searchResult = this.memData
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
