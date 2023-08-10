<template>
    <PageTitle :title="'小遊戲管理'" />
    <div class="game_container">
        <div class="mb-3 ps-3 pe-3 search_bar_group">
            <div class="d-flex justify-content-between">
                <div class="input-group" style="width: fit-content">
                    <span class="input-group-text">搜尋結果</span>
                    <input type="text" class="form-control" placeholder="請輸入人格種類或狀態" @input="searchIdOrPhone"
                        v-model="searchInput" />
                </div>

                <!-- 新增 -->
                <div class="create">
                    <button class="btn btn-primary create-btn" @click="openModal(null)" type="button"
                        style="margin-left: auto; color: #fff">
                        新增結果
                    </button>
                </div>
            </div>
        </div>

        <!-- 表格 -->
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="(item, index) in colTitle" :key="index">
                        {{ item }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in showData" :key="index">

                    <td>{{ item.result_no }}</td>
                    <td>{{ item.personality }}</td>
                    <td>
                        <select name="" id="" style="width: 200px; border-radius: 20px; padding: 4px;">
                            <option>{{ item.dish1_recipe }}</option>
                            <option>{{ item.dish2_recipe }}</option>
                            <option>{{ item.dish3_recipe }}</option>
                            <option>{{ item.dish4_recipe }}</option>
                        </select>
                    </td>
                    <td>{{ truncateText(item.content) }}</td>
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

        <label for="id">結果編號:<input type="text" :value="newData.result_no || gameIdNum()" id="id"
                disabled="disabled"></label>

        <label for="personality">人格種類:
            <input type="text" :value="newData.personality" id="personality" />
        </label>

        <label for="" v-for="index in 4" :key="index">推薦菜色{{ index }}:
            <select :value="newData['dish' + index + '_recipe']" @input="updateDishRecipe(index, $event.target.value)">
                <option :value="newData.dish1_recipe">{{ newData.dish1_recipe }}</option>
                <option :value="newData.dish2_recipe">{{ newData.dish2_recipe }}</option>
                <option :value="newData.dish3_recipe">{{ newData.dish3_recipe }}</option>
                <option :value="newData.dish4_recipe">{{ newData.dish4_recipe }}</option>
            </select>
        </label>


        <label for="txt" style="display: flex;">分析結果:
            <textarea name="" id="txt" cols="30" rows="6">{{ newData.content }}</textarea>
        </label>

        <button class="delete">刪除</button>
        <button class="archive">存檔</button>
        <!-- 關閉按鍵 -->
        <button class="xmark" @click="closeModal">x</button>
    </div>
</template>
<script>
import PageTitle from "@/components/PageTitle.vue";
import PageComponent from "@/components/PageComponent.vue";

export default {
    name: "GameView",
    components: {
        PageComponent,
        PageTitle,
    },
    data() {
        return {
            showModal: false,
            presetData: {
                id: null,
                personality: " ",
                txt: ` `,
                status: '未套用',
                productLists: [
                    {
                        name: " ",
                        category: "主菜",
                        amount: 1,
                    },
                    {
                        name: " ",
                        category: "主菜",
                        amount: 1,
                    },
                    {
                        name: " ",
                        category: "湯品",
                        amount: 1,
                    },
                    {
                        name: " ",
                        category: "沙拉",
                        amount: 1,
                    },
                ],
            },
            newData: null,
            showData: [],
            searchInput: "",
            searchResult: [],
            colTitle: ["結果編號", "人格種類", "推薦菜色", "分析結果", "狀態", ""],
            productName: [
                { name: "滑嫩番茄蛋" },
                { name: "奶油啤酒蛤蠣" },
                { name: "塔香茄子" },
                { name: "生烤貝" },
                { name: "麻婆豆腐" },
                { name: "中華彗星炒飯" },
                { name: "泡椒炒鮮魚" },
                { name: "法國紅酒燉雞" },
                { name: "阿根廷燉牛肉" },
                { name: "泰國綠咖喱" },
                { name: "希臘烤羊肉" },
                { name: "西班牙海鮮燉飯" },
                { name: "日本櫻花蝦天婦羅" },
                { name: "越南河粉湯" },
                { name: "意大利肉醬千層麵" },
                { name: "日本味噌鮮魚湯" },
                { name: "韓國辣椒醬湯" },
                { name: "法國洋蔥湯" },
                { name: "馬來西亞椰奶雞湯" },
                { name: "葡萄牙海鮮湯" },
                { name: "西班牙番茄湯" },
                { name: "墨西哥辣味雞肉湯" },
                { name: "泰式酸辣湯" },
                { name: "意大利米蘭湯" },
                { name: "糖漬番茄" },
                { name: "泰式生菜包" },
                { name: "中東麥麩沙拉" },
                { name: "印度瑪撒拉薯仔沙拉" },
                { name: "巴西凱撒沙拉" },
                { name: "希臘風味水果沙拉" },
                { name: "越南涼拌牛肉" },
                { name: "加拿大蔓越莓野菜沙拉" },
                { name: "日式涼拌海帶絲" },
            ],
            gameData: []
        };
    },
    methods: {
        searchIdOrPhone() {
            console.log(this.searchInput);
            if (this.searchInput == '') {
                this.searchResult = this.gameData
            }
            let stateResult = this.gameData.filter(item => {
                return item.status.includes(this.searchInput)
            })
            let personalityResult = this.gameData.filter(item => {
                return item.personality.includes(this.searchInput)
            })
            if (stateResult.length > 0) {
                this.searchResult = stateResult;
            } else if (personalityResult.length > 0) {
                this.searchResult = personalityResult;
            }
        },
        getPageData(data) {
            this.showData = data;
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
        gameIdNum() {
            const gameIdNum = this.gameData.length + 1;
            return gameIdNum;
        },
        //取得資料庫資料
        getGameData() {
            let url = `${this.$url}gameRows.php`
            this.axios.get(url).then(res => {
                this.gameData = res.data
            }).catch(err => {
                console.log(err);
            })
        },
        updateDishRecipe(index, value) {
            this.newData['dish' + index + '_recipe'] = value;
        }
    },
    created() {
        this.searchResult = this.gameData
    },
    watch: {
        gameData: {
            handler: function () {
                this.searchResult = this.gameData
            },
            deep: true
        },
    },
    mounted() {
        this.getGameData()
    },
};
</script>

<style lang="scss">
.show_modal {
    border: 3px solid #1f8d61;
    border-radius: 20px;
    width: fit-content;
    padding: $sp2;
    position: relative;
    position: fixed;
    font-weight: 700;
    background-color: #fff7ea;
    z-index: 5;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    overflow: auto;
    height: fit-content;

    .xmark {
        right: 5px;
        top: 5px;
        position: absolute;
        border: none;
        background-color: #fff7ea;
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

    .archive,
    .delete {
        background-color: #fff7ea;
        border: #1f8d61 1px solid;
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
