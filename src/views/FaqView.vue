<template>
    <PageTitle :title="'FAQ管理'" />
    <div class="game_container">
        <div class="mb-3 ps-3 pe-3 search_bar_group">
            <div class="d-flex justify-content-between">
                <div class="input-group" style="width: fit-content;">
                    <span class="input-group-text">搜尋結果</span>
                    <input type="text" class="form-control" placeholder="請輸入分類或狀態" @input="searchIdOrPhone"
                        v-model="searchInput" />
                </div>

                <!-- 新增 -->
                <div class="create">
                    <button class="btn btn-primary create-btn" @click="openModal(null)" type="button"
                        style="margin-left: auto; color: #fff">新增問答</button>
                </div>
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

                    <td>{{ item.question_group }}</td>
                    <td>{{ truncateText(item.question_des) }}</td>
                    <td>{{ truncateText(item.ans) }}</td>
                    <td>
                        <span v-if="item.status == 0">未套用</span>
                        <span v-if="item.status == 1">套用</span>
                    </td>
                    <td><button class="btn btn-outline-primary btn-sm" @click="openModal(item)">查閱</button></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- 頁碼 -->
    <PageComponent :data="searchResult" @changePage="getPageData" />

    <!-- 彈窗 -->

    <div class="show_modal d-flex flex-column align-items-start gap-2" v-if="showModal">

        <label for="">狀態:
            <select v-model="newData.status">
                <option value="1">套用</option>
                <option value="0">未套用</option>
            </select>
        </label>


        <label for="">分類:<select v-model="newData.question_group">
                <option value="常見問題">常見問題</option>
                <option value="會員註冊">會員註冊</option>
                <option value="付款問題">付款問題</option>
                <option value="寄送問題">寄送問題</option>
                <option value="購物相關">購物相關</option>
                <option value="訂單問題">訂單問題</option>
                <option value="禮物卡相關">禮物卡相關</option>
                <option value="退換貨問題">退換貨問題</option>
            </select> </label>


        <label for="" style="display: flex;">標題:
            <textarea name="" id="" cols="30" rows="3">{{ newData.question_des }}</textarea>
        </label>
        <label for="" style="display: flex;">內容:
            <textarea name="" id="" cols="30" rows="10">{{ newData.ans }}</textarea>
        </label>
        <button class="delete">刪除</button>
        <button class="archive">存檔</button>

        <!-- 關閉按鍵 -->
        <button class="xmark btn btn-outline-secondary " @click="closeModal">
            x
        </button>
    </div>
</template>
<script>
import PageTitle from '@/components/PageTitle.vue';

import PageComponent from "@/components/PageComponent.vue";
export default {
    name: 'FaqView',
    components: {
        PageComponent,
        PageTitle,
    },
    data() {
        return {
            showModal: false,
            presetData: {
                id: null,
                type: '常見問題',
                state: '未套用',
                questions: ' ',
                answers: ' ',
                open: false
            },
            newData: null,
            showData: [],
            searchInput: '',
            searchResult: [],
            colTitle: ["分類", "標題", "內容", "狀態", ""],

            faqData: []
        };
    },
    methods: {
        searchIdOrPhone() {
            console.log(this.searchInput);
            if (this.searchInput == '') {
                this.searchResult = this.faqData
            }
            let typeResult = this.faqData.filter(item => {
                return item.question_group.includes(this.searchInput)
            })
            let stateResult = this.faqData.filter(item => {
                return item.status.includes(this.searchInput)
            })
            if (typeResult.length > 0) {
                this.searchResult = typeResult
            } else if ((stateResult.length > 0)) {
                this.searchResult = stateResult
            }
        },
        //控制顯示字數 多的用"..."省略
        truncateText(text) {
            if (text && text.length > 6) {
                // 檢查 text 是否存在並且長度大於 6
                return text.slice(0, 6) + "...";
            }
            return text;
        },
        //開啟彈窗,帶入data值
        openModal(item) {
            this.showModal = true;
            console.log(this.presetData);
            if (item === null) {
                this.newData = this.presetData;
            } else {
                this.newData = item;
            }
        },
        closeModal() {
            this.showModal = false;
        },
        getPageData(data) {
            this.showData = data
        },
        //取得資料庫資料
        getFaqData() {
            let url = `${this.$url}faqRows.php`
            this.axios.get(url).then(res => {
                this.faqData = res.data
            }).catch(err => {
                console.log(err);
            })
        },
    },
    created() {
        this.searchResult = this.faqData
    },
    watch: {
        faqData: {
            handler: function () {
                this.searchResult = this.faqData
            },
            deep: true
        },
    },
    mounted() {
        this.getFaqData()
    },



};
</script>

<style lang="scss">
// @import 'bootstrap/dist/css/bootstrap.min.css';
// @import '@/assets/scss/all.scss';
// @import "@/assets/scss/page/ingredients.scss";

.show_modal {
    border: 3px solid #1F8D61;
    border-radius: 20px;
    width: fit-content;
    padding: 30px;
    position: relative;
    position: fixed;
    font-weight: 700;
    background-color: #FFF7EA;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    overflow: auto;
    height: fit-content;

    .xmark {
        right: 5px;
        top: 5px;
        position: absolute;
    }

    label {

        select,
        textarea,
        input {
            padding: 0 5px;
            margin-left: 5px;
        }
    }

    .archive,
    .delete {
        background-color: #FFF7EA;
        border: #1F8D61 1px solid;
        border-radius: 20px;
        width: 90%;
        margin: 10px auto 0;

        &:hover {
            background-color: #1f8d61;
            color: #fff7ea;
        }
    }
}
</style>
