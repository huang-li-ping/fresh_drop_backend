<template>
    <PageTitle :title="'食材管理'" />
    <div class="ingredient_container">
        <div class="mb-3 ps-3 pe-3 search_bar_group">
            <div class="d-flex justify-content-between">
                <!-- 搜尋框 -->
                <div class="input-group">
                    <span class="input-group-text">搜尋食材</span>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="請輸入食材名稱或編號"
                        @input="searchIdOrName"
                        v-model="searchInput"
                    />
                </div>
                <!-- 新增 -->
                <button
                    class="btn btn-primary create-btn"
                    type="button"
                    style="margin-left: auto; color: #fff"
                >
                    新增菜色
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
                    <td>{{ item.ingred_no }}</td>
                    <td>{{ item.ingred_name }}</td>
                    <td>{{ item.allergy }}</td>
                    <td>{{ item.dislike }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- 頁碼 -->
    <PageComponent :data="searchResult" @changePage="getPageData" />
    <!-- 彈窗 -->
    <div
        class="show_modal_ingred d-flex flex-column align-items-start gap-2"
        v-if="showModal"
    >
        <label for=""
            >編號：<input type="text" :value="newData.ingred_no" disabled
        /></label>
        <label for=""
            >名稱：<input type="text" :value="newData.ingred_name" />
        </label>
        <label for="allergy"
            ><input type="checkbox" id="allergy" v-model="allergyChecked" />
            過敏原</label
        >
        <label for="dislike"
            ><input type="checkbox" id="dislike" v-model="dislikeChecked" />
            不喜歡的食物</label
        >
        <button class="delete">刪除</button>
        <button class="archive">存檔</button>
        <!-- 關閉按鍵 -->
        <button class="xmark" @click="closeModal">x</button>
    </div>
</template>
<script>
import PageComponent from "@/components/PageComponent.vue";
import PageTitle from "@/components/PageTitle.vue";

export default {
    name: "IngredientView",
    components: {
        PageTitle,
        PageComponent,
    },
    data() {
        return {
            dislikeChecked: false,
            allergyChecked: false,
            showModal: false,
            newData: [],
            searchInput: "",
            searchResult: [],
            showData: [],
            colTitle: ["", "食材編號", "食材名稱", "過敏原", "不喜愛的"],
            foodData: [],
        };
    },
    methods: {
        //串接ingred資料庫
        getFoodData() {
            let url = `${this.$url}ingredRows.php`;
            this.axios
                .get(url)
                .then((res) => {
                    this.foodData = res.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        searchIdOrName() {
            if (this.searchInput == "") {
                this.searchResult = this.foodData;
            }
            let idResult = this.foodData.filter((item) => {
                return item.ingred_no.includes(this.searchInput);
            });
            let nameResult = this.foodData.filter((item) => {
                return item.ingred_name.includes(this.searchInput);
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
    watch: {
        // 監聽 newData.allergy 的變化
        "newData.allergy": function (newallergy) {
            this.allergyChecked = newallergy === "是";
        },
        // 監聽 newData.dislike 的變化
        "newData.dislike": function (newDislike) {
            this.dislikeChecked = newDislike === "是";
        },
        //串接ingred資料庫
        foodData: {
            handler: function () {
                this.searchResult = this.foodData;
            },
            deep: true,
        },
    },
    mounted() {
        //串接ingred資料庫
        this.getFoodData();
    },
};
</script>

<style lang="scss">
// @import 'bootstrap/dist/css/bootstrap.min.css';
// @import '@/assets/scss/all.scss';
@import "@/assets/scss/page/ingredients.scss";

.ingredient_container {
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

.show_modal_ingred {
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
    // height: calc(100vh - 100px);
    height: fit-content;
    overflow: auto;

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
        width: 100%;
        margin: 10px auto 0;

        &:hover {
            background-color: #1f8d61;
            color: #fff7ea;
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
</style>
