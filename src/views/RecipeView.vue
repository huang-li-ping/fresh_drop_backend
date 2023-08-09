<template>
    <PageTitle :title="'菜色管理'" />
    <div class="recipe_container">
        <div class="mb-3 ps-3 pe-3 search_bar_group">
            <div class="d-flex justify-content-between">
                <!-- 搜尋框 -->
                <div class="input-group">
                    <span class="input-group-text">搜尋菜色</span>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="請輸入菜色名稱或編號"
                        @input="searchIdOrName"
                        v-model="searchInput"
                    />
                </div>
                <!-- <div class="btn btn-outline-primary" @click="searchIdOrName">
                    搜尋
                </div> -->
                <!-- 新增 -->
                <div class="btn btn-outline-primary">新增</div>
            </div>
        </div>
        <!-- 表格 -->
        <table class="table table-hover">
            <thead>
                <tr>
                    <th
                        scope="col"
                        v-for="(item, index) in colTitle"
                        :key="index"
                    >
                        {{ item }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in showData" :key="index">
                    <td>
                        <button
                            class="edit-button btn btn-sm btn-outline-secondary rounded-5"
                            @click="openModal(item)"
                        >
                            <font-awesome-icon icon="fa-solid fa-pen" />
                        </button>
                    </td>
                    <td>{{ item.recipe_no }}</td>
                    <td>{{ item.recipe_name }}</td>
                    <td>
                        <span v-if="item.class == 0">主菜</span>
                        <span v-if="item.class == 1">湯品</span>
                        <span v-if="item.class == 2">沙拉</span>
                    </td>
                    <td>
                        {{ truncateText(item.quantity_unit) }}
                    </td>

                    <td>{{ truncateText(item.step) }}</td>
                    <td>{{ truncateText(item.recipe_pic) }}</td>
                    <td>{{ truncateText(item.des) }}</td>
                    <td>
                        <div class="input-group-append">
                            <button
                                class="btn btn-outline-primary"
                                type="button"
                            >
                                <span v-if="item.state == 0">上架</span>
                                <span v-if="item.state == 1">下架</span>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- 頁碼 -->
        <PageComponent :data="searchResult" @changePage="getPageData" />
        <!-- 彈窗 -->
        <div
            class="show_modal d-flex flex-column align-items-start gap-2"
            v-if="showModal"
        >
            <!-- <div class="show_modal_wrap"> -->
            <label for=""
                >類別：
                <select id="category" v-model="newData.category">
                    <option :value="newData.category">主菜</option>
                    <option :value="newData.category">湯品</option>
                    <option :value="newData.category">沙拉</option>
                </select>
            </label>
            <label for=""
                >編號：
                <input class="recipe_no" type="text" :value="newData.id"
            /></label>
            <label for=""
                >名稱：
                <input class="recipe_name" type="text" :value="newData.name" />
            </label>
            <label for="des">菜色描述：</label>
            <textarea
                class="recipe_des"
                id="des"
                v-model="newData.des"
                rows="4"
            ></textarea>
            <div>食材表：</div>
            <div class="ingred_wrap">
                <div
                    class="ingred_table"
                    v-for="(inputData, index) in inputDataArray"
                    :key="index"
                >
                    <div class="ingred_input">
                        <!-- <label for="ingred_item">
                                <input
                                    type="text"
                                    id="ingred_item"
                                    v-model="newData.ingred"
                                />
                            </label>
                            <label for="ingred_unit">
                                <input
                                    type="text"
                                    id="ingred_unit"
                                    v-model="newData.ingred"
                                />
                            </label> -->
                        <label for="ingred_item">
                            <input
                                type="text"
                                :id="'ingred_item_' + index"
                                v-model="inputData.ingred"
                            />
                        </label>
                        <label for="ingred_unit">
                            <input
                                type="text"
                                :id="'ingred_unit_' + index"
                                v-model="inputData.unit"
                            />
                        </label>
                    </div>
                    <div class="ingred_btn">
                        <button class="reduce" @click="reduceInput(index)">
                            <font-awesome-icon icon="fa-solid fa-minus" />
                        </button>
                        <button class="increase" @click="increaseInput(index)">
                            <font-awesome-icon icon="fa-solid fa-plus" />
                        </button>
                    </div>
                </div>
            </div>
            <label for="step">製作步驟：</label>
            <textarea
                class="recipe_step"
                id="step"
                v-model="newData.step"
                rows="6"
            ></textarea>
            <!-- <label for=""
                    >照片： <input type="file" :value="newData.img" />
                </label> -->
            <!-- </div> -->
            <div class="recipe_btn">
                <button class="delete">刪除</button>
                <button class="archive">存檔</button>
            </div>
            <!-- 關閉按鍵 -->
            <button class="xmark" @click="closeModal">x</button>
        </div>
    </div>
</template>
<script>
import PageComponent from "@/components/PageComponent.vue";
import PageTitle from "@/components/PageTitle.vue";

export default {
    name: "RecipeView",
    components: {
        PageTitle,
        PageComponent,
    },
    data() {
        return {
            showModal: false,
            newData: [],
            searchInput: "",
            searchResult: [],
            showData: [],
            inputDataArray: [
                { ingred: "", unit: "" }, // 初始化輸入
            ],
            colTitle: [
                "",
                "菜色編號",
                "菜色名稱",
                "類別",
                "食材內容",
                "製作步驟",
                "菜色照片",
                "菜色介紹",
                "狀態",
            ],
            recipeData: [],
        };
    },
    methods: {
        //串接recipe資料庫
        getRecipeData() {
            let url = `${this.$url}recipeRows.php`;
            this.axios
                .get(url)
                .then((res) => {
                    this.recipeData = res.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        searchIdOrName() {
            if (this.searchInput == "") {
                this.searchResult = this.recipeData;
            }
            let idResult = this.recipeData.filter((item) => {
                return item.recipe_no.includes(this.searchInput);
            });
            let nameResult = this.recipeData.filter((item) => {
                return item.recipe_name.includes(this.searchInput);
            });
            if (idResult.length > 0) {
                this.searchResult = idResult;
            } else if (nameResult.length > 0) {
                this.searchResult = nameResult;
            }
        },
        getPageData(data) {
            this.showData = data;
        },
        truncateText(text) {
            if (text && text.length > 6) {
                // 檢查 text 是否存在並且長度大於 6
                return text.slice(0, 6) + "...";
            }
            return text;
        },
        //彈窗
        openModal(item) {
            this.showModal = true;
            this.newData = item;
        },
        closeModal() {
            this.showModal = false;
        },
        //增減欄位
        reduceInput(index) {
            if (this.inputDataArray.length > 1) {
                this.inputDataArray.splice(index, 1);
            }
        },
        increaseInput(index) {
            const newInputData = { ingred: "", unit: "" };
            this.inputDataArray.splice(index + 1, 0, newInputData);
        },
    },
    created() {
        this.searchResult = this.recipeData;
    },
    watch: {
        //串接recipe資料庫
        recipeData: {
            handler: function () {
                this.searchResult = this.recipeData;
            },
            deep: true,
        },
    },
    mounted() {
        //串接recipe資料庫
        this.getRecipeData();
    },
};
</script>

<style lang="scss">
// @import 'bootstrap/dist/css/bootstrap.min.css';
// @import '@/assets/scss/all.scss';
@import "@/assets/scss/page/ingredients.scss";

.recipe_container {
    .input-group {
        width: fit-content;
        position: relative;
    }

    .add_td {
        max-width: 150px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
}

.show_modal {
    border: 3px solid #1f8d61;
    border-radius: 20px;
    width: fit-content;
    padding: $sp4;
    padding-top: 50px;
    position: relative;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-weight: 700;
    background-color: #fff7ea;
    z-index: 5;
    height: calc(100vh - 100px);
    overflow: auto;

    label {
        select,
        textarea,
        input {
            padding: 0 5px;
            margin-left: 5px;
        }
    }
}

.xmark {
    right: 20px;
    top: 10px;
    position: absolute;
    border: none;
    background-color: #fff7ea;
    font-size: $m-font;
    color: #aaa;
}

.recipe_btn {
    width: 100%;
    margin-top: 10px;
    background-color: #fff7ea;
    display: flex;
    flex-direction: column;
    gap: 10px;
    // position: fixed;
    // bottom: 0px;
    // padding: 32px;
    // border-radius: 0 0 20px 20px;

    .delete,
    .archive {
        background-color: #fff7ea;
        border: #1f8d61 1px solid;
        border-radius: 20px;
        // width: 90%;
        // margin: 10px auto 0;

        &:hover {
            background-color: #1f8d61;
            color: #fff7ea;
        }
    }
}

// .show_modal_wrap {
//     padding: $sp4;
//     display: flex;
//     flex-direction: column;
//     align-items: flex-start;
//     gap: 5px;
//     overflow: auto;
//     height: calc(100vh - 50px);
// }

.recipe_des {
    width: 100%;
    min-height: 100px;
}

.recipe_step {
    width: 100%;
    min-height: 150px;
}

.ingred_wrap {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.ingred_table {
    width: 100%;
    display: flex;

    .ingred_input {
        display: flex;
    }

    .ingred_btn {
        width: 20%;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        padding: 0 5px;

        .reduce,
        .increase {
            border: none;
            background-color: $primary;
            color: #ffffff;
            width: 25px;
            height: 25px;
            text-align: center;
            display: inline-block;
            cursor: pointer;
            border-radius: 50%;
            flex-shrink: 0;
        }
    }
}
</style>
