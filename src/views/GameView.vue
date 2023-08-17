<template>
    <PageTitle :title="'小遊戲管理'" />
    <div class="game_container">
        <div class="mb-3 ps-3 pe-3 search_bar_group">
            <div class="d-flex justify-content-between">
                <div class="input-group" style="width: fit-content">
                    <span class="input-group-text">搜尋結果</span>
                    <input type="text" class="form-control" placeholder="請輸入人格種類或編號" @input="searchIdOrPhone"
                        v-model="searchInput" />
                </div>

                <!-- 新增 -->
                <div class="create">
                    <button class="btn btn-primary create-btn" @click="openAddModal" type="button"
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
                            <option disabled="disabled">{{ item.dish2_recipe }}</option>
                            <option disabled="disabled">{{ item.dish3_recipe }}</option>
                            <option disabled="disabled">{{ item.dish4_recipe }}</option>
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

    <!-- 修改&刪除彈窗 -->
    <form id="revise_faq" method="POST" enctype="multipart/form-data" @submit.prevent action="#">
        <div class="show_modal_game d-flex flex-column align-items-start gap-2" v-if="showModal">

            <label for="result_no">結果編號:<input type="text" :value="newData.result_no || gameIdNum()" id="result_no"
                    name="result_no" disabled="disabled"></label>

            <label for="status">狀態:
                <select v-model="newData.status" id="status" name="status">
                    <option value="1">套用</option>
                    <option value="0">未套用</option>
                </select>
            </label>


            <label for="personality">人格種類:
                <input type="text" :value="newData.personality" id="personality" name="personality" />
            </label>

            <!-- <label for="recipe_name" v-for="index in 4" :key="index">推薦菜色{{ index }}:
                <select :value="newData['dish' + index + '_recipe']" @input="updateDishRecipe(index, $event.target.value)">
                    <option v-for="(item) in recipeData" :key="item">{{ item.recipe_name }}</option>
                </select>
            </label>

            <label for="recipe_name" v-for="index in  4 " :key="index">推薦菜色{{ index }}:
                <select :v-model="`dish${index}`" :name="`dish${index}`" :id="`dish${index}`">
                    <option v-for="( item ) in  recipeData " :key="item" :value="`${item.recipe_no}`">{{
                        item.recipe_name }}
                    </option>
                </select>
            </label> -->

            <label for="">推薦菜色1:
                <select name="dish1" id="dish1" v-model="newData.dish1">
                    <option v-for="(item) in recipeData" :key="item.recipe_no" :value="item.recipe_no">
                        {{ item.recipe_name }}
                    </option>
                </select>
            </label>
            <label for="">推薦菜色2:
                <select name="dish2" id="dish2" v-model="newData.dish2">
                    <option v-for="(item) in recipeData" :key="item.recipe_no" :value="item.recipe_no">
                        {{ item.recipe_name }}
                    </option>
                </select>
            </label>
            <label for="">推薦菜色3:
                <select name="dish3" id="dish3" v-model="newData.dish3">
                    <option v-for="(item) in recipeData" :key="item.recipe_no" :value="item.recipe_no">
                        {{ item.recipe_name }}
                    </option>
                </select>
            </label>
            <label for="">推薦菜色4:
                <select name="dish4" id="dish4" v-model="newData.dish4">
                    <option v-for="(item) in recipeData" :key="item.recipe_no" :value="item.recipe_no">
                        {{ item.recipe_name }}
                    </option>
                </select>
            </label>



            <label for="content" style="display: flex;">分析結果:
                <textarea id="content" name="content" cols="30" rows="6">{{ newData.content }}</textarea>
            </label>

            <button class="btn btn-primary col-12" style="color:#fff" type="submit" name="submit" value="修改"
                @click="handleSubmit('存檔')">存檔</button>
            <button class="btn btn-outline-secondary col-12" type="submit" name="submit" value="刪除"
                @click="handleSubmit('刪除')">刪除</button>

            <!-- 關閉按鍵 -->
            <button class="xmark btn btn-outline-secondary rounded-5" @click="closeModal">
                x
            </button>
        </div>
    </form>

    <!-- 新增彈窗 -->

    <form id="revise_game" method="POST" enctype="multipart/form-data" @submit.prevent action="#">
        <div class="show_modal_game d-flex flex-column align-items-start gap-2" v-if="showAddModal">

            <label for="result_no">結果編號：<input type="text" :value="gameIdNum()" id="result_no" name="result_no"></label>

            <label for="status">狀態:
                <select id="status" name="status">
                    <option value="1">套用</option>
                    <option value="0">未套用</option>
                </select>
            </label>

            <label for="personality" class="inline-label">人格種類:<input type="text" value="" id="personality"
                    name="personality"></label>

            <label for="">推薦菜色1:
                <select name="dish1" id="dish1">
                    <option v-for="(item) in recipeData" :key="item.recipe_no" :value="item.recipe_no">
                        {{ item.recipe_name }}
                    </option>
                </select>
            </label>
            <label for="">推薦菜色2:
                <select name="dish2" id="dish2">
                    <option v-for="(item) in recipeData" :key="item.recipe_no" :value="item.recipe_no">
                        {{ item.recipe_name }}
                    </option>
                </select>
            </label>
            <label for="">推薦菜色3:
                <select name="dish3" id="dish3">
                    <option v-for="(item) in recipeData" :key="item.recipe_no" :value="item.recipe_no">
                        {{ item.recipe_name }}
                    </option>
                </select>
            </label>
            <label for="">推薦菜色4:
                <select name="dish4" id="dish4">
                    <option v-for="(item) in recipeData" :key="item.recipe_no" :value="item.recipe_no">
                        {{ item.recipe_name }}
                    </option>
                </select>
            </label>

            <label for="content" style="display: flex;">分析結果:
                <textarea id="content" name="content" cols="30" rows="6"></textarea>
            </label>


            <button class="btn btn-primary col-12" style="color:#fff" type="submit" name="submit" value="新增"
                @click="handleSubmit('新增')">新增</button>

            <!-- 關閉按鍵 -->
            <button class="xmark btn btn-outline-secondary rounded-5" @click="closeModal">
                x
            </button>

        </div>
    </form>
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
            showModal: false, // 修改刪除的彈窗
            showAddModal: false, //新增的彈窗
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
            gameData: [],
            recipeData: [],
        };
    },
    methods: {
        searchIdOrPhone() {
            console.log(this.searchInput);
            if (this.searchInput == '') {
                this.searchResult = this.gameData
            }
            let stateResult = this.gameData.filter(item => {

                return item.result_no.toString().includes(this.searchInput);
            })
            let personalityResult = this.gameData.filter(item => {

                return (
                    typeof item.personality == "string" &&
                    item.personality.includes(this.searchInput)
                );
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
            this.showAddModal = false;

        },
        //開啟新增視窗
        openAddModal() {
            this.showAddModal = true;

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
        },
        //串接recipe資料庫
        getRecipeData() {
            let url = `${this.$url}recipeRows.php`;
            this.axios
                .get(url)
                .then((res) => {
                    console.log(res.data);
                    this.recipeData = res.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        //新增&修改&刪除
        handleSubmit(submitType) {
            let url = `${this.$url}gameInsertUpdate.php`
            const formData = new FormData();
            const result_no = document.querySelector('#result_no')?.value;
            const status = document.querySelector('#status')?.value;
            const personality = document.querySelector('#personality')?.value;
            const dish1 = document.querySelector('#dish1')?.value;
            const dish2 = document.querySelector('#dish2')?.value;
            const dish3 = document.querySelector('#dish3')?.value;
            const dish4 = document.querySelector('#dish4')?.value;
            const content = document.querySelector('#content')?.value;
            formData.append("result_no", result_no);
            formData.append("status", status);
            formData.append("personality", personality);
            formData.append("dish1", dish1);
            formData.append("dish2", dish2);
            formData.append("dish3", dish3);
            formData.append("dish4", dish4);
            formData.append("content", content);
            formData.append("submit", submitType);

            this.axios.post(url, formData).then(res => {
                console.log(res)
                this.getGameData()
                this.closeModal()
            }).catch(err => {
                console.log(err);
            })
        },
        // 改變顯示菜名
        // changeRecipeName(num) {
        //     const selectedRecipe = this.recipeData.find(item => item.recipe_no === this.newData[`dish${num}`]);
        //     if (selectedRecipe) {
        //         this[`dish${num}_recipe`] = selectedRecipe.recipe_name;
        //     }
        // },
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
        this.getGameData();
        //串接recipe資料庫
        this.getRecipeData();
    },
};
</script>

<style lang="scss">
.show_modal_game {
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
