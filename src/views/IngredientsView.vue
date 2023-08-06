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
                <div class="btn btn-outline-primary" @click="searchIdOrName">
                    搜尋
                </div>
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
                    <td>{{ item.id }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.allergen }}</td>
                    <td>{{ item.dislike }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- 頁碼 -->
    <PageComponent :data="searchResult" @changePage="getPageData" />

    <!-- 彈窗 -->

    <div
        class="show_modal d-flex flex-column align-items-start gap-2"
        v-if="showModal"
    >
        <label for="">編號: <input type="text" :value="newData.id" /></label>
        <label for="">名稱: <input type="text" :value="newData.name" /> </label>
        <label for="allergen"
            ><input type="checkbox" id="allergen" v-model="allergenChecked" />
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
            allergenChecked: false,
            showModal: false,
            newData: [],
            searchInput: "",
            searchResult: [],
            showData: [],
            colTitle: ["", "食材編號", "食材名稱", "過敏原", "不喜歡的食物"],
            foodData: [
                { id: "1", name: "蛋", allergen: "是", dislike: "否" },
                { id: "2", name: "番茄", allergen: "否", dislike: "是" },
                { id: "3", name: "洋蔥", allergen: "否", dislike: "是" },
                { id: "4", name: "蒜末", allergen: "是", dislike: "否" },
                { id: "5", name: "胡椒粉", allergen: "無", dislike: "無" },
                { id: "6", name: "香菜", allergen: "否", dislike: "是" },
                { id: "7", name: "鹽", allergen: "無", dislike: "無" },
                { id: "8", name: "青蔥", allergen: "否", dislike: "是" },
                { id: "9", name: "蛤蠣", allergen: "是", dislike: "否" },
                { id: "10", name: "奶油", allergen: "是", dislike: "否" },
                { id: "11", name: "啤酒", allergen: "是", dislike: "否" },
                { id: "12", name: "海帶絲", allergen: "否", dislike: "是" },
                { id: "13", name: "美乃滋醬", allergen: "無", dislike: "無" },
                { id: "14", name: "茄子", allergen: "否", dislike: "是" },
                { id: "15", name: "薑末", allergen: "無", dislike: "無" },
                { id: "16", name: "辣椒粉", allergen: "是", dislike: "否" },
                { id: "17", name: "醬油", allergen: "是", dislike: "否" },
                { id: "18", name: "糖", allergen: "是", dislike: "否" },
                { id: "19", name: "白芝麻", allergen: "是", dislike: "否" },
                { id: "20", name: "新鮮生貝", allergen: "是", dislike: "否" },
                { id: "21", name: "檸檬", allergen: "無", dislike: "無" },
                { id: "22", name: "牛油", allergen: "無", dislike: "無" },
                { id: "23", name: "大蒜", allergen: "是", dislike: "否" },
                { id: "24", name: "新鮮香草", allergen: "無", dislike: "無" },
                { id: "25", name: "豆腐", allergen: "是", dislike: "否" },
                { id: "26", name: "豬絞肉", allergen: "否", dislike: "是" },
                { id: "27", name: "辣豆瓣醬", allergen: "是", dislike: "否" },
                { id: "28", name: "蒸熟的白飯", allergen: "否", dislike: "無" },
                { id: "29", name: "黑芝麻", allergen: "是", dislike: "否" },
                { id: "30", name: "蔥花", allergen: "無", dislike: "無" },
                { id: "31", name: "香菜碎", allergen: "否", dislike: "是" },
                { id: "32", name: "鮮魚", allergen: "是", dislike: "否" },
                { id: "33", name: "泡椒", allergen: "是", dislike: "否" },
                { id: "34", name: "薑絲", allergen: "無", dislike: "無" },
                { id: "35", name: "雞肉", allergen: "否", dislike: "是" },
                { id: "36", name: "紅蘿蔔", allergen: "否", dislike: "是" },
                { id: "37", name: "牛肉", allergen: "否", dislike: "是" },
                { id: "38", name: "紅辣椒", allergen: "是", dislike: "是" },
                { id: "39", name: "青椒", allergen: "否", dislike: "是" },
                { id: "40", name: "大蒜瓣", allergen: "是", dislike: "否" },
                { id: "41", name: "蕃茄", allergen: "無", dislike: "無" },
                { id: "42", name: "番茄醬", allergen: "否", dislike: "是" },
                { id: "43", name: "高湯", allergen: "無", dislike: "無" },
                { id: "44", name: "橄欖油", allergen: "無", dislike: "無" },
                { id: "45", name: "黑胡椒粉", allergen: "無", dislike: "無" },
                { id: "46", name: "綠咖喱醬", allergen: "無", dislike: "無" },
                { id: "47", name: "椰奶", allergen: "是", dislike: "否" },
                { id: "48", name: "瓣大蒜", allergen: "是", dislike: "否" },
                { id: "49", name: "檸檬葉", allergen: "否", dislike: "無" },
                { id: "50", name: "魚露", allergen: "是", dislike: "否" },
                {
                    id: "51",
                    name: "新鮮泰國香菜",
                    allergen: "無",
                    dislike: "無",
                },
                { id: "52", name: "羊肉肩胛肉", allergen: "否", dislike: "是" },
                { id: "53", name: "新鮮迷迭香", allergen: "無", dislike: "無" },
                { id: "54", name: "新鮮百里香", allergen: "無", dislike: "無" },
                { id: "55", name: "新鮮酸橙汁", allergen: "無", dislike: "無" },
                { id: "56", name: "檸檬汁", allergen: "無", dislike: "無" },
                {
                    id: "57",
                    name: "西班牙海鮮燉飯底",
                    allergen: "無",
                    dislike: "無",
                },
                { id: "58", name: "海鮮混合物", allergen: "無", dislike: "無" },
                { id: "59", name: "番紅花", allergen: "無", dislike: "無" },
                { id: "60", name: "義大利米", allergen: "無", dislike: "無" },
                { id: "61", name: "蕃茄罐頭", allergen: "無", dislike: "無" },
                { id: "62", name: "高湯或水", allergen: "無", dislike: "無" },
                { id: "63", name: "辣椒醬", allergen: "是", dislike: "否" },
                { id: "64", name: "櫻花蝦", allergen: "是", dislike: "否" },
                { id: "65", name: "麵粉", allergen: "是", dislike: "否" },
                { id: "66", name: "麻油", allergen: "無", dislike: "無" },
                { id: "67", name: "冷水", allergen: "無", dislike: "無" },
                { id: "68", name: "油", allergen: "無", dislike: "無" },
                {
                    id: "69",
                    name: "越南河粉（即米粉）",
                    allergen: "無",
                    dislike: "無",
                },
                { id: "70", name: "雞肉或牛肉", allergen: "否", dislike: "是" },
                {
                    id: "71",
                    name: "雞湯或牛肉湯",
                    allergen: "否",
                    dislike: "是",
                },
                { id: "72", name: "生豆芽", allergen: "否", dislike: "是" },
                { id: "73", name: "辣椒", allergen: "是", dislike: "否" },
                { id: "74", name: "蒜頭", allergen: "是", dislike: "否" },
                { id: "75", name: "蔓越莓乾", allergen: "否", dislike: "是" },
                { id: "76", name: "千層麵片", allergen: "無", dislike: "無" },
                { id: "77", name: "牛絞肉", allergen: "無", dislike: "無" },
                { id: "78", name: "罐裝番茄醬", allergen: "否", dislike: "是" },
                { id: "79", name: "番茄醬膏", allergen: "否", dislike: "是" },
                { id: "80", name: "乾燥香料", allergen: "無", dislike: "無" },
                { id: "81", name: "越南河粉", allergen: "無", dislike: "無" },
                {
                    id: "82",
                    name: "莫札瑞拉乳酪",
                    allergen: "是",
                    dislike: "否",
                },
                { id: "83", name: "帕馬森乳酪", allergen: "是", dislike: "否" },
                {
                    id: "84",
                    name: "鮮魚片（如鮭魚、鱈魚等）",
                    allergen: "是",
                    dislike: "否",
                },
                { id: "85", name: "蔥", allergen: "無", dislike: "無" },
                { id: "86", name: "味噌", allergen: "否", dislike: "是" },
                {
                    id: "87",
                    name: "海帶（昆布）",
                    allergen: "否",
                    dislike: "是",
                },
                { id: "88", name: "温水", allergen: "無", dislike: "無" },
                {
                    id: "89",
                    name: "韓國辣椒醬（Gochujang）",
                    allergen: "是",
                    dislike: "否",
                },
                {
                    id: "90",
                    name: "韓國辣椒粉（Gochugaru）",
                    allergen: "是",
                    dislike: "否",
                },
                {
                    id: "91",
                    name: "雞湯或蔬菜湯",
                    allergen: "無",
                    dislike: "無",
                },
                {
                    id: "92",
                    name: "高湯（雞湯或蔬菜湯）",
                    allergen: "無",
                    dislike: "無",
                },
                {
                    id: "93",
                    name: "白酒（選擇性）",
                    allergen: "是",
                    dislike: "否",
                },
                { id: "94", name: "乾白葡萄酒", allergen: "是", dislike: "否" },
                { id: "95", name: "百里香", allergen: "無", dislike: "無" },
                {
                    id: "96",
                    name: "洋蔥湯包或香料袋",
                    allergen: "否",
                    dislike: "是",
                },
                { id: "97", name: "紅椒", allergen: "無", dislike: "無" },
                {
                    id: "98",
                    name: "磨碎的帕瑪森芝士（或其他起司）",
                    allergen: "無",
                    dislike: "無",
                },
                { id: "99", name: "薑", allergen: "無", dislike: "無" },
                { id: "100", name: "香茅", allergen: "無", dislike: "無" },
                { id: "101", name: "蜂蜜", allergen: "是", dislike: "否" },
                {
                    id: "102",
                    name: "魚肉或蝦肉",
                    allergen: "是",
                    dislike: "否",
                },
                {
                    id: "103",
                    name: "蔬菜（例如洋蔥、蒜頭、紅蘿蔔、馬鈴薯等）",
                    allergen: "是",
                    dislike: "否",
                },
                {
                    id: "104",
                    name: "葡萄牙香腸（可選）",
                    allergen: "無",
                    dislike: "無",
                },
                {
                    id: "105",
                    name: "蔬菜湯或魚湯",
                    allergen: "是",
                    dislike: "否",
                },
                { id: "106", name: "蕃茄醬", allergen: "無", dislike: "無" },
                { id: "107", name: "歐芹", allergen: "無", dislike: "無" },
                { id: "108", name: "黃瓜", allergen: "無", dislike: "無" },
                { id: "109", name: "黃椒", allergen: "無", dislike: "無" },
                { id: "110", name: "醋", allergen: "無", dislike: "無" },
                { id: "111", name: "麵包", allergen: "無", dislike: "無" },
                {
                    id: "112",
                    name: "青蔥或歐芹",
                    allergen: "否",
                    dislike: "是",
                },
                { id: "113", name: "米醋", allergen: "無", dislike: "無" },
                { id: "114", name: "罐裝番茄", allergen: "無", dislike: "無" },
                { id: "115", name: "花椒粉", allergen: "無", dislike: "無" },
                {
                    id: "116",
                    name: "蔬菜湯或雞湯",
                    allergen: "無",
                    dislike: "無",
                },
                {
                    id: "117",
                    name: "玉米餅（可選）",
                    allergen: "無",
                    dislike: "無",
                },
                {
                    id: "118",
                    name: "雞肉或蝦肉",
                    allergen: "是",
                    dislike: "否",
                },
                {
                    id: "119",
                    name: "蔬菜（例如洋蔥、蘑菇、番茄等）",
                    allergen: "否",
                    dislike: "是",
                },
                { id: "120", name: "青檸葉", allergen: "無", dislike: "無" },
                { id: "121", name: "檸檬草", allergen: "否", dislike: "是" },
                { id: "122", name: "蔥段", allergen: "無", dislike: "無" },
                {
                    id: "123",
                    name: "雞湯或清水",
                    allergen: "無",
                    dislike: "無",
                },
                { id: "124", name: "青檸汁", allergen: "無", dislike: "無" },
                {
                    id: "125",
                    name: "擺盤所需的食材（例如，薄荷葉或檸檬片）",
                    allergen: "無",
                    dislike: "無",
                },
                { id: "126", name: "葡萄", allergen: "無", dislike: "無" },
                {
                    id: "127",
                    name: "香菜或泰國香菜（可選）",
                    allergen: "無",
                    dislike: "無",
                },
                { id: "128", name: "西芹", allergen: "無", dislike: "無" },
                { id: "129", name: "香菇", allergen: "無", dislike: "無" },
                {
                    id: "130",
                    name: "高湯或蔬菜湯",
                    allergen: "無",
                    dislike: "無",
                },
                {
                    id: "131",
                    name: "義大利細麵或通心粉",
                    allergen: "無",
                    dislike: "無",
                },
                {
                    id: "132",
                    name: "義大利香草調味料（如乾燥的羅勒、百里香、迷迭香）",
                    allergen: "無",
                    dislike: "無",
                },
                { id: "133", name: "砂糖", allergen: "是", dislike: "否" },
                { id: "134", name: "白醋", allergen: "無", dislike: "無" },
                { id: "135", name: "水", allergen: "無", dislike: "無" },
                { id: "136", name: "生菜葉", allergen: "無", dislike: "無" },
                {
                    id: "137",
                    name: "雞肉或牛肉絲",
                    allergen: "否",
                    dislike: "是",
                },
                { id: "138", name: "青檸", allergen: "無", dislike: "無" },
                { id: "139", name: "蜜瓜", allergen: "無", dislike: "無" },
                { id: "140", name: "花生碎", allergen: "是", dislike: "否" },
                { id: "141", name: "麥麩", allergen: "是", dislike: "否" },
                { id: "142", name: "黑豆罐頭", allergen: "是", dislike: "否" },
                { id: "143", name: "青瓜", allergen: "無", dislike: "無" },
                { id: "144", name: "紅洋蔥", allergen: "無", dislike: "無" },
                { id: "145", name: "薄荷葉", allergen: "無", dislike: "無" },
                { id: "146", name: "馬鈴薯", allergen: "無", dislike: "無" },
                { id: "147", name: "瑪撒拉粉", allergen: "無", dislike: "無" },
                { id: "148", name: "黑鹽", allergen: "無", dislike: "無" },
                { id: "149", name: "生菜", allergen: "無", dislike: "無" },
                { id: "150", name: "雞胸肉", allergen: "無", dislike: "無" },
                {
                    id: "151",
                    name: "帕馬森乾酪",
                    allergen: "無",
                    dislike: "無",
                },
                { id: "152", name: "西瓜", allergen: "無", dislike: "無" },
                { id: "153", name: "蜜瓜", allergen: "無", dislike: "無" },
            ],
        };
    },
    methods: {
        searchIdOrName() {
            if (this.searchInput == "") {
                this.searchResult = this.foodData;
            }
            let idResult = this.foodData.filter((item) => {
                return item.id.includes(this.searchInput);
            });
            let nameResult = this.foodData.filter((item) => {
                return item.name.includes(this.searchInput);
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
        // 監聽 newData.allergen 的變化
        "newData.allergen": function (newAllergen) {
            this.allergenChecked = newAllergen === "是";
        },
        // 監聽 newData.dislike 的變化
        "newData.dislike": function (newDislike) {
            this.dislikeChecked = newDislike === "是";
        },
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
    left: 40%;
    top: 20%;
    font-weight: 700;
    background-color: #fff7ea;
    z-index: 5;

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
    }
}
</style>
