<template>
    <PageTitle :title="'食材管理'" />
    <div class="ingredient_container">
        <div class="mb-3 ps-3 pe-3 search_bar_group">
            <div class="d-flex justify-content-between">
                <!-- 搜尋框 -->
                <div class="input-group">
                    <span class="input-group-text">搜尋食材</span>
                    <input type="text" class="form-control" placeholder="請輸入食材名稱或編號" @input="searchIdOrName"
                        v-model="searchInput" />
                </div>
                <!-- 新增 -->
                <button class="btn btn-primary create-btn" type="button" style="margin-left: auto; color: #fff"
                    @click="openAddModal">
                    新增菜色
                </button>
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
                    <td>
                        <button class="edit-button btn btn-sm btn-outline-secondary rounded-5" @click="openModal(item)">
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
    <!-- 修改&刪除彈窗 -->
    <div class="show_modal d-flex flex-column align-items-start gap-2" v-if="showModal">
        <label for="ingred_no">編號：<input type="text" :value="newData.ingred_no" disabled id="ingred_no"
                name="ingred_no" /></label>
        <label for="ingred_name">名稱：<input type="text" :value="newData.ingred_name" id="ingred_name" name="ingred_name" />
        </label>
        <label for="allergy">
            <input type="checkbox" id="allergy" name="allergy" v-model="allergyChecked" />
            過敏原
        </label>
        <label for="dislike">
            <input type="checkbox" id="dislike" name="dislike" v-model="dislikeChecked" />
            不喜歡的食物
        </label>

        <button class="btn btn-primary col-12" style="color:#fff" type="submit" name="submit" value="修改"
            @click="handleSubmit('存檔')">存檔</button>
        <button class="btn btn-outline-secondary col-12" type="submit" name="submit" value="刪除"
            @click="handleSubmit('刪除')">刪除</button>

        <!-- 關閉按鍵 -->
        <button class="xmark btn btn-outline-secondary rounded-5" @click="closeModal(currentItem)">
            x
        </button>
    </div>
    <!-- 新增彈窗 -->

    <form id="revise_game" method="POST" enctype="multipart/form-data" @submit.prevent action="#">
        <div class="show_modal d-flex flex-column align-items-start gap-2" v-if="showAddModal">

            <label for="ingred_no">編號：<input type="text" :value="ingredIdNum()" disabled id="ingred_no"
                    name="ingred_no" /></label>


            <label for="ingred_name">名稱：<input type="text" id="ingred_name" name="ingred_name" />
            </label>

            <label for="allergy">
                <input type="checkbox" id="allergy" v-model="allergyChecked" />
                過敏原
            </label>
            <label for="dislike">
                <input type="checkbox" id="dislike" v-model="dislikeChecked" />
                不喜歡的食物
            </label>



            <button class="btn btn-primary col-12" style="color:#fff" type="submit" name="submit" value="新增"
                @click="handleSubmit('新增')">新增</button>

            <!-- 關閉按鍵 -->
            <button class="xmark btn btn-outline-secondary rounded-5" @click="closeModal(currentItem)">
                x
            </button>

        </div>
    </form>
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
            showModal: false, // 修改刪除的彈窗
            showAddModal: false, //新增的彈窗
            newData: [],
            searchInput: "",
            searchResult: [],
            showData: [],
            colTitle: ["", "食材編號", "食材名稱", "過敏原", "不喜愛的"],
            foodData: [],
            currentItem: [],
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
            console.log(this.newData)

        },
        closeModal() {
            this.showModal = false;
            this.showAddModal = false;

            this.allergyChecked = false;
            this.dislikeChecked = false;

        },

        //開啟新增視窗
        openAddModal() {
            this.showAddModal = true;


        },
        ingredIdNum() {
            const ingredIdNum = this.foodData.length + 1;
            return ingredIdNum;
        },
        //新增&修改&刪除
        handleSubmit(submitType) {
            let url = `${this.$url}ingredInsertUpdate.php`;
            const formData = new FormData();
            const ingred_no = document.querySelector('#ingred_no')?.value;
            const ingred_name = document.querySelector('#ingred_name')?.value;



            // 如果都没有选中，则设置为 NULL
            if (!this.allergyChecked && !this.dislikeChecked) {
                allergy = null;
                dislike = null;
            }

            formData.append("ingred_no", ingred_no);
            formData.append("ingred_name", ingred_name);
            formData.append("allergy", +this.allergyChecked);
            formData.append("dislike", +this.dislikeChecked);
            formData.append("submit", submitType);

            this.axios.post(url, formData).then(res => {
                console.log(res)
                this.getFoodData()
                this.closeModal()
            }).catch(err => {
                console.log(err);
            });
        },
    },
    created() {
        this.searchResult = this.foodData;
    },
    watch: {
        //串接ingred資料庫
        foodData: {
            handler: function () {
                this.searchResult = this.foodData;
            },
            deep: true,
        },
        "newData.ingred_no"() {
            this.allergyChecked = this.newData.allergy === '是';
            this.dislikeChecked = this.newData.dislike === '是';

        },

        // 监听 newData.allergy 的变化
        // "newData.allergy": function (newallergy) {
        //     if (newallergy === true) {
        //         this.allergyChecked = true;
        //         this.dislikeChecked = false;
        //         this.newData.allergy = "1";
        //         this.newData.dislike = "0";
        //     } else {
        //         this.allergyChecked = false;
        //         if (this.newData.dislike !== true) {
        //             this.newData.allergy = null;
        //         }
        //     }
        // },
        // 监听 newData.dislike 的变化
        // "newData.dislike": function (newDislike) {
        //     if (newDislike === true) {
        //         this.dislikeChecked = true;
        //         this.allergyChecked = false;
        //         this.newData.dislike = "1";
        //         this.newData.allergy = "0";
        //     } else {
        //         this.dislikeChecked = false;
        //         if (this.newData.allergy !== true) {
        //             this.newData.dislike = null;
        //         }
        //     }
        // },
        // ...



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
