<template>
    <PageTitle :title="'烹飪心得管理'" />
    <div class="report_container">
        <!-- 搜尋框 -->
        <div class="mb-3 ps-3 pe-3 search_bar_group">
            <div class="d-flex justify-content-between">
                <div class="input-group">
                    <span class="input-group-text">搜尋菜色</span>
                    <input type="text" class="form-control" placeholder="請輸入菜色" @input="searchIdOrPhone" v-model="searchInput"/>
                    <div class="btn btn-outline-primary" @click="searchIdOrPhone">搜尋</div> 
                </div>
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
            <tr v-for="(item, index) in showData" :key="index">
            <td>{{ item.opinion_no }}</td>
            <td>{{ item.member }}</td>
            <td>{{ item.recipeno }}</td>
            <td>
                <div class="recipe_pic">
                <img :src="require(`./@/../../../../fresh_drop/src/assets/images/product/${item.opinion_no_pic}`)" alt="">
                </div>
            </td>
            <td>{{ truncateText(item.experience, 4) }}</td>
            <td>{{ item.share_time }}</td>
            <td>
                <span v-if="item.state == 0">未套用</span>
                <span v-if="item.state == 1">套用</span>
            </td>
            <td><button class="btn btn-outline-primary btn-sm" @click="handleDelete(item)">下架</button></td>
            </tr>
        </tbody>
    </table>
    <!-- 頁碼 -->
    <PageComponent :data="searchResult" @changePage="getPageData" />
</template>
<script>
import PageComponent from '@/components/PageComponent.vue';
import PageTitle from '@/components/PageTitle.vue';

export default {
    name: 'opinionView',
    components: {
        PageComponent,
        PageTitle,
    },
    data() {
        return {
            colTitle: ["心得分享編號", "會員編號", "食譜編號", "心得照片", "心得", "日期", "狀態","上下架",],
            opinionData: [],
            showModal: false,
            newData: [],
            searchInput: "",
            searchResult: [],
            showData: [],
        };
    },
    methods: {
        //串接ingred資料庫        
        getopinionData() {
            let url = `${this.$url}opinionRows.php`
            this.axios.get(url).then(res => {
                this.opinionData = res.data
            }).catch(err => {
                console.log(err);
            })
        },
        searchIdOrPhone() {
            if (this.searchInput == "") {
                this.searchResult = this.opinionData;
            }
            let idResult = this.opinionData.filter((item) => {
                return item.member.includes(this.searchInput);
            });
            if (idResult.length > 0) {
                this.searchResult = idResult;
            } else if (nameResult.length > 0) {
                this.searchResult = nameResult;
            }
        },    
        // 上下架
        handleDelete(item) {
        let url = `${this.$url}opiniondelete.php`;
        const formData = new FormData();
        formData.append("opinion_no", item.opinion_no);
        formData.append("submit", "刪除"); // 修改此处

        this.axios.post(url, formData).then(response => {
            console.log(response.data);
            this.getopinionData();
        }).catch(error => {
            console.error(error);
        });
        },
        getPageData(data) {
                this.showData = data
            },
        truncateText(text) {
            if (text && text.length > 10) {
                // 檢查 text 是否存在並且長度大於 10
                return text.slice(0, 10) + "...";
            }
            return text;
        },
        openModal(item) {
                this.showModal = true;
                this.newData = item;
            },
        closeModal() {
            this.showModal = false;
        },
    },
    created() {
        this.searchResult = this.opinionData;
    },
    //串接ingred資料庫
    watch:{
        opinionData: {
        handler: function () {
            console.log('watch');
            this.searchResult = this.opinionData;
        },
        deep: true,
        },

    },
    mounted (){
    //串接ingred資料庫
    this.getopinionData()
    },
};
</script>

<style lang="scss">
@import "@/assets/scss/page/ingredients.scss";
.report_container {
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
.show_modal {
    position: fixed;
    left: 50%;
    transform: translate(-50%,-50%);
    top: 50%;
    border: 3px solid #1F8D61;
    border-radius: 20px;
    width: fit-content;
    padding: $sp2;
    position: relative;
    position: fixed;
    font-weight: 700;
    background-color: #FFF7EA;
    z-index: 5;

    .xmark {
        right: 5px;
        top: 5px;
        position: absolute;
        border: none;
        background-color: #FFF7EA;
        font-size: $m-font;
        color: #aaa;
    }

    label {

        select,
        textarea,
        input {
            padding: 0 5px;
            margin-left: 5px;
        }
    }
    .report_content{
        border: 3px solid #1F8D61;
        width: 400px;
        display: flex;
        .report_pic{
            width: 200px;
            margin: 20px;
        }
        img{
            width: 100%;
            border-radius: 20px;
        }
    }
    .report_name{
        margin: auto;
        display: block;
        width: 200px;
        .report_member{
            display: flex;
            text-align: left;
            gap: 15px;
            .report_name_pic{
                width: 50px;
                border-radius: 20px;
                img{
                    width: 100%;
                }
            }
        }
        .report_me{
            h6{
                line-height: 45px;
            }
        }
        .report_text{
            text-align: left;
            margin-top: 18px;
        }
    }
    .button_bt{
        display: flex;
        margin: auto;
        gap: 10px;
      .dismissed,
    .reported {
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
}
td{
    align-items: center;
    vertical-align: middle;
}
.recipe_pic{
        display: block;
        margin: auto;
        width: 80px;
        img{
            width: 100%;
        }
    }
</style>
