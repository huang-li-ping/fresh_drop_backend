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
                <!-- 新增 -->
                <button
                    class="btn btn-primary create-btn"
                    type="button"
                    style="margin-left: auto; color: #fff"
                    @click="openAddModal"
                >
                    新增食材
                </button>
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
                        <!-- {{ item.class }} -->
                        <span v-if="item.class == 0">主菜</span>
                        <span v-if="item.class == 1">湯品</span>
                        <span v-if="item.class == 2">沙拉</span>
                    </td>
                    <td>
                        {{ truncateText(getFirstIngredName(item)) }}
                    </td>
                    <td>{{ truncateText(item.step) }}</td>
                    <td>
                        <div class="recipe_pic">
                            <img
                                :src="
                                    require(`./@/../../../../fresh_drop/src/assets/images/product/${item.recipe_pic}`)
                                "
                                alt=""
                            />
                        </div>
                    </td>
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
        <!-- 修改&刪除彈窗 -->
        <form
            id="revise_faq"
            method="POST"
            enctype="multipart/form-data"
            @submit.prevent
            action="#"
        >
            <div
                class="show_modal_recipe d-flex flex-column align-items-start gap-2"
                v-if="showModal"
            >
                <label for="class"
                    >類別：
                    <select id="class" name="class" v-model="newData.class">
                        <option value="0">主菜</option>
                        <option value="1">湯品</option>
                        <option value="2">沙拉</option>
                    </select>
                </label>
                <label for=""
                    >編號：
                    <input
                        class="recipe_no"
                        type="text"
                        id="recipe_no"
                        name="recipe_no"
                        :value="newData.recipe_no"
                        disabled
                /></label>
                <label for=""
                    >名稱：
                    <input
                        class="recipe_name"
                        id="recipe_name"
                        name="recipe_name"
                        type="text"
                        :value="newData.recipe_name"
                    />
                </label>
                <label for="des">菜色描述：</label>
                <textarea
                    class="recipe_des"
                    id="des"
                    name="des"
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
                            <label :for="'ingred_item' + index">
                                <input
                                    type="text"
                                    :id="'ingred_item_' + index"
                                    v-model="inputData.ingred_name"
                                />
                            </label>
                            <label :for="'ingred_unit' + index">
                                <input
                                    type="text"
                                    :id="'ingred_unit_' + index"
                                    v-model="inputData.quantity_unit"
                                />
                            </label>
                        </div>
                        <div class="ingred_btn">
                            <button class="reduce" @click="reduceInput(index)">
                                <font-awesome-icon icon="fa-solid fa-minus" />
                            </button>
                            <button
                                class="increase"
                                @click="increaseInput(index)"
                            >
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
                <label for="">菜色照片：</label>
                <div class="upload_file">
                    <!-- <div class="upload_pic" v-if="previewImage"> -->
                    <div class="upload_pic">
                        <!-- <img
                        class="pic"
                        :src="previewImage"
                        alt="Preview"
                    /> -->
                        <img
                            class="pic"
                            :src="
                                previewImage ||
                                require(`./@/../../../../fresh_drop/src/assets/images/product/${newData.recipe_pic}`)
                            "
                            alt="Preview"
                        />
                    </div>
                    <button class="file_btn" @click="triggerFileInput">
                        <p class="file_text">點擊上傳照片</p>
                    </button>
                    <input
                        id="fileInput"
                        type="file"
                        ref="fileInput"
                        @change="handleFileUpload"
                        style="display: none"
                    />
                </div>
                <div class="recipe_btn">
                    <button class="delete">刪除</button>
                    <button class="archive">存檔</button>
                </div>
                <!-- 關閉按鍵 -->
                <button class="xmark" @click="closeModal">x</button>
            </div>
        </form>

        <!-- 新增彈窗 -->

        <form
            id="revise_game"
            method="POST"
            enctype="multipart/form-data"
            @submit.prevent
            action="#"
        >
            <div
                class="show_modal_recipe d-flex flex-column align-items-start gap-2"
                v-if="showAddModal"
            >
                <label for="result_no"
                    >結果編號：<input
                        type="text"
                        :value="gameIdNum()"
                        id="result_no"
                        name="result_no"
                /></label>

                <label for="status"
                    >狀態:
                    <select id="status" name="status">
                        <option value="1">套用</option>
                        <option value="0">未套用</option>
                    </select>
                </label>

                <label for="personality" class="inline-label"
                    >人格種類:<input
                        type="text"
                        value=""
                        id="personality"
                        name="personality"
                /></label>

                <label for=""
                    >推薦菜色1:
                    <select name="dish1" id="dish1">
                        <option
                            v-for="item in recipeData"
                            :key="item.recipe_no"
                            :value="item.recipe_no"
                        >
                            {{ item.recipe_name }}
                        </option>
                    </select>
                </label>
                <label for=""
                    >推薦菜色2:
                    <select name="dish2" id="dish2">
                        <option
                            v-for="item in recipeData"
                            :key="item.recipe_no"
                            :value="item.recipe_no"
                        >
                            {{ item.recipe_name }}
                        </option>
                    </select>
                </label>
                <label for=""
                    >推薦菜色3:
                    <select name="dish3" id="dish3">
                        <option
                            v-for="item in recipeData"
                            :key="item.recipe_no"
                            :value="item.recipe_no"
                        >
                            {{ item.recipe_name }}
                        </option>
                    </select>
                </label>
                <label for=""
                    >推薦菜色4:
                    <select name="dish4" id="dish4">
                        <option
                            v-for="item in recipeData"
                            :key="item.recipe_no"
                            :value="item.recipe_no"
                        >
                            {{ item.recipe_name }}
                        </option>
                    </select>
                </label>

                <label for="content" style="display: flex"
                    >分析結果:
                    <textarea
                        id="content"
                        name="content"
                        cols="30"
                        rows="6"
                    ></textarea>
                </label>

                <button
                    class="btn btn-primary col-12"
                    style="color: #fff"
                    type="submit"
                    name="submit"
                    value="新增"
                    @click="handleSubmit('新增')"
                >
                    新增
                </button>

                <!-- 關閉按鍵 -->
                <button
                    class="xmark btn btn-outline-secondary rounded-5"
                    @click="closeModal"
                >
                    x
                </button>
            </div>
        </form>
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
            showModal: false, // 修改刪除的彈窗
            showAddModal: false, //新增的彈窗
            newData: [],
            searchInput: "",
            searchResult: [],
            showData: [],
            inputDataArray: [{ ingred: "", unit: "" }],
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
            //上傳圖片
            previewImage: null,
        };
    },
    methods: {
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
        searchIdOrName() {
            if (this.searchInput == "") {
                this.searchResult = this.recipeData;
            }
            let idResult = this.recipeData.filter((item) => {
                // return item.recipe_no.includes(this.searchInput);
                return item.recipe_no.toString().includes(this.searchInput);
            });
            let nameResult = this.recipeData.filter((item) => {
                // return item.recipe_name.includes(this.searchInput);
                return (
                    typeof item.recipe_name == "string" &&
                    item.recipe_name.includes(this.searchInput)
                );
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
            this.showAddModal = false;
        },
        //開啟新增視窗
        openAddModal() {
            this.showAddModal = true;
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
        // 食材表Rows
        getFirstIngredName(item) {
            if (item.ingreds && item.ingreds.length > 0) {
                const firstIngred = item.ingreds[0];
                return `${firstIngred.ingred_name}：${firstIngred.quantity_unit}`;
            }
            return "";
        },
        //上傳圖片
        triggerFileInput() {
            this.$refs.fileInput.click();
        },
        handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.previewImage = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                this.previewImage = null;
            }
        },
        //新增&修改&刪除
        handleSubmit(submitType) {
            let url = `${this.$url}gameInsertUpdate.php`;
            const formData = new FormData();
            const result_no = document.querySelector("#result_no")?.value;
            const status = document.querySelector("#status")?.value;
            const personality = document.querySelector("#personality")?.value;
            const dish1 = document.querySelector("#dish1")?.value;
            const dish2 = document.querySelector("#dish2")?.value;
            const dish3 = document.querySelector("#dish3")?.value;
            const dish4 = document.querySelector("#dish4")?.value;
            const content = document.querySelector("#content")?.value;
            formData.append("result_no", result_no);
            formData.append("status", status);
            formData.append("personality", personality);
            formData.append("dish1", dish1);
            formData.append("dish2", dish2);
            formData.append("dish3", dish3);
            formData.append("dish4", dish4);
            formData.append("content", content);
            formData.append("submit", submitType);

            this.axios
                .post(url, formData)
                .then((res) => {
                    console.log(res);
                    this.getGameData();
                    this.closeModal();
                })
                .catch((err) => {
                    console.log(err);
                });
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
        showModal(nVal) {
            if (!nVal) return;
            this.inputDataArray = [...this.newData.ingreds];
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

td {
    vertical-align: middle;
}

.recipe_pic {
    display: block;
    margin: auto;
    width: 50px;

    img {
        width: 100%;
    }
}

.show_modal_recipe {
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

.upload_file {
    width: 100%;
    height: 200px;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    flex-shrink: 0;

    &::placeholder {
        width: 100px;
    }

    .file_btn {
        z-index: 10;
        width: 100%;
        height: 100%;
        background-color: transparent;

        .file_text {
            background-color: #ffffffaa;
            padding: 6px 20px;
            border-radius: 20px;
            display: inline-block;
        }
    }

    .upload_pic {
        position: absolute;

        img {
            width: 100%;
        }
    }
}
</style>
