<template>
    <PageTitle :title="'檢舉管理'" />
    <div class="report_container">
            <!-- 搜尋框 -->
            <div class="mb-3 ps-3 pe-3 search_bar_group">
            <div class="d-flex justify-content-between">
                <div class="input-group">
                    <span class="input-group-text">搜尋菜色</span>
                    <input type="text" class="form-control" placeholder="請輸入手機號碼或會員編號" @input="searchIdOrPhone" v-model="searchInput"/>
                </div>
                <div class="btn btn-outline-primary" @click="searchIdOrPhone">搜尋</div>
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
                <td>{{ item.id }}</td>
                <td>{{ item.recipe }}</td>
                <td><img :src="item.pic" alt=""></td>
                <td>{{ truncateText(item.comment, 6) }}</td>
                <td>{{ item.date }}</td>
                <td>{{ item.state }}</td>
                <td>{{ item.report }}</td>
                <td><button class="btn btn-outline-primary btn-sm" @click="openModal(item)">查閱</button></td>
            </tr>
        </tbody>
    </table>
    <!-- 頁碼 -->
    <PageComponent :data="searchResult" @changePage="getPageData" />

    <!-- 彈窗 -->
    <div class="show_modal d-flex flex-column align-items-start gap-2" v-if="showModal">
        <!-- <label for="">狀態:
            <select v-model="newData.state">
                <option value="套用">套用</option>
                <option value="未套用">未套用</option>
            </select>
        </label>

        <label for="">結果編號:<input type="text" :value="newData.id"></label>

        <label for="">人格種類: <input type="text" :value="newData.personality"> </label>


        <label for="" style="display: flex;">分析結果:
            <textarea name="" id="" cols="30" rows="6">{{ newData.txt }}</textarea>
        </label> -->
        <h4>被檢舉內容：</h4>
        <div class="report_content">
            <div class="report_pic">
                <img src="./@/../../../../fresh_drop_i/src/assets/images/product/11greece_roast_lamb.jpg" alt="">
            </div>
            <div class="report_name">
                <div class="report_member">
                    <div class="report_name_pic">
                        <img src="./@/../../../../fresh_drop_i/src/assets/images/product/p1.jpg" alt="">
                    </div>  
                    <div class="report_name">
                        <h4>sukl4;g</h4>
                    </div>  
                </div>
                <div class="report_text">
                    <p>我就說這道菜很屌~</p>
                </div>
            </div>
        </div>
        <div class="button_bt">
            <button class="dismissed">檢舉駁回</button>
            <button class="reported">檢舉通過</button> 
        </div>

        <!-- 關閉按鍵 -->
        <button class="xmark" @click="closeModal">
            x
        </button>
    </div>
</template>
<script>
import PageTitle from '@/components/PageTitle.vue';
import PageComponent from '@/components/PageComponent.vue';

// import PageComponent from "@/components/PageComponent.vue";
export default {
    name: 'ReportView',
    components: {
        PageComponent,
        PageTitle,
    },
    data() {
        return {
            colTitle: ["提報檢舉會員", "被檢舉會員", "照片", "評論", "日期", "狀態", "檢舉",""],
            foodData: [
                { id: "1", recipe: "綠咖哩", pic: "s1.jpg", comment: "我就說這道菜很屌~", date: "2023/5/12",state:"上架",report:"套用",},
                { id: "2", recipe: "111", pic: "s2.jpg", comment: "今天翹課坐火車回家，就是為了媽媽煮的這道菜！", date: "2023/5/12",state:"上架",report:"套用",},
                { id: "3", recipe: "綠咖哩", pic: "s3.jpg", comment: "住太遠uber送不到，只好自己在家做了。", date: "2023/5/12",state:"上架",report:"套用",},
                { id: "4", recipe: "綠咖哩", pic: "s3.jpg", comment: "覺得好吃的舉手~", date: "2023/5/12",state:"上架",report:"套用",},
                { id: "5", recipe: "綠咖哩", pic: "s1.jpg", comment: "剛從美國釣到的鮮魚，拿來做菜最適合", date: "2023/5/12",state:"上架",report:"套用",},
                { id: "6", recipe: "綠咖哩", pic: "s5.jpg", comment: "看到檸檬葉要怎麼樣~馬上做成綠咖哩", date: "2023/5/12",state:"上架",report:"套用",},
                { id: "7", recipe: "綠咖哩", pic: "s6.jpg", comment: "做到第幾道菜了?", date: "2023/5/12",state:"上架",report:"套用",},
                { id: "8", recipe: "綠咖哩", pic: "s1.jpg", comment: "感謝分享~~", date: "2023/5/12",state:"上架",report:"套用",},
                { id: "9", recipe: "綠咖哩", pic: "s2.jpg", comment: "綠咖哩中加入椰奶可以平衡辣味~", date: "2023/5/12",state:"上架",report:"套用",},
                { id: "10", recipe: "111", pic: "s3.jpg", comment: "如果你喜歡海鮮，將鮮蝦或魚片加入綠咖哩中，可以有豐富的海鮮風味，讓整道菜更好吃。", date: "2023/5/12",state:"上架",report:"套用",},
                { id: "11", recipe: "111", pic: "s3.jpg", comment: "如果你喜歡海鮮，將鮮蝦或魚片加入綠咖哩中，可以有豐富的海鮮風味，讓整道菜更好吃。", date: "2023/5/12",state:"上架",report:"套用",},
                { id: "10", recipe: "111", pic: "s3.jpg", comment: "如果你喜歡海鮮，將鮮蝦或魚片加入綠咖哩中，可以有豐富的海鮮風味，讓整道菜更好吃。", date: "2023/5/12",state:"上架",report:"套用",},
                { id: "11", recipe: "111", pic: "s3.jpg", comment: "如果你喜歡海鮮，將鮮蝦或魚片加入綠咖哩中，可以有豐富的海鮮風味，讓整道菜更好吃。", date: "2023/5/12",state:"上架",report:"套用",},
                { id: "10", recipe: "111", pic: "s3.jpg", comment: "如果你喜歡海鮮，將鮮蝦或魚片加入綠咖哩中，可以有豐富的海鮮風味，讓整道菜更好吃。", date: "2023/5/12",state:"上架",report:"套用",},
                { id: "11", recipe: "111", pic: "s3.jpg", comment: "如果你喜歡海鮮，將鮮蝦或魚片加入綠咖哩中，可以有豐富的海鮮風味，讓整道菜更好吃。", date: "2023/5/12",state:"上架",report:"套用",},
            ],
            showModal: false,
            newData: [],
            searchInput: '',
            searchResult: [],
            showData: [],
        };
    },
    methods: {
    searchIdOrPhone() {
        console.log('type')
      if (this.searchInput == '') {
        this.searchResult = this.foodData;
      } else {
        let idResult = this.foodData.filter(item => {
          return item.recipe.includes(this.searchInput);
        });
        console.log(idResult)
        if (idResult.length > 0) {
                this.searchResult = idResult
        }
      }
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
        this.searchResult = this.foodData;
    },
};
</script>

<style lang="scss">
// @import 'bootstrap/dist/css/bootstrap.min.css';
// @import '@/assets/scss/all.scss';
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
</style>
<style lang="scss">
.show_modal {
    border: 3px solid #1F8D61;
    border-radius: 20px;
    width: fit-content;
    padding: $sp2;
    position: relative;
    position: fixed;
    left: 40%;
    top: 2%;
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
        .report_member{
            display: flex;
            margin: 30px;
            gap: 15px;
            .report_name_pic{
                width: 40px;
                height: 40px;
                border-radius: 20px;
                img{
                    width: 100%;
                }
            }
        }
        .report_name{
            h4{

            }
        }
        .report_text{
            p{

            }
        }
    }
    .button_bt{
        display: flex;
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
</style>
