<template>
    <PageTitle :title="'小遊戲管理'" />
    <div class="game_container">
        <div class="mb-3 ps-3 pe-3 search_bar_group">
            <div class="d-flex justify-content-between">
                <div class="input-group" style="width: fit-content">
                    <span class="input-group-text">搜尋結果</span>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="請輸入人格種類或狀態"
                        @input="searchIdOrPhone"
                        v-model="searchInput"
                    />
                </div>

                <!-- 新增 -->
                <div class="create">
                    <button
                        class="btn btn-primary create-btn"
                        @click="openModal(null)"
                        type="button"
                        style="margin-left: auto; color: #fff"
                    >
                        新增結果
                    </button>
                </div>
            </div>
            <div class="col-2 create" style="margin-left:auto">
        <button class="btn btn-primary create-btn" @click="openModal" type="button" style="margin-left: auto; color: #fff" >新增帳號</button>
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
                    <td>{{ item.id }}</td>
                    <td>{{ item.personality }}</td>
                    <td>
                        <select
                            name=""
                            id=""
                            style="
                                width: 200px;
                                border-radius: 20px;
                                padding: 4px;
                            "
                        >
                            <option
                                value=""
                                v-for="(proItem, proIndex) in item.productLists"
                                :key="proIndex"
                            >
                                {{ proItem.name }}
                            </option>
                        </select>
                    </td>
                    <td>{{ truncateText(item.txt, 6) }}</td>
                    <td>{{ item.state }}</td>
                    <td>
                        <button
                            class="btn btn-outline-primary btn-sm"
                            @click="openModal(item)"
                        >
                            查閱
                        </button>
                    </td>
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
        <label for=""
            >狀態:
            <select v-model="newData.state">
                <option value="套用">套用</option>
                <option value="未套用">未套用</option>
            </select>
        </label>

        <label for="id"
            >結果編號:<input
                type="text"
                :value="newData.id || gameIdNum()"
                id="id"
                disabled="disabled"
        /></label>

        <label for="personality"
            >人格種類:
            <input type="text" :value="newData.personality" id="personality" />
        </label>

        <label for="" v-for="(item, index) in newData.productLists" :key="index"
            >推薦菜色{{ index + 1 }}:
            <select v-model="item.name">
                <option
                    v-for="(item, index) in productName"
                    :key="index"
                    :value="item.name"
                >
                    {{ item.name }}
                </option>
            </select>
        </label>

        <label for="txt" style="display: flex"
            >分析結果:
            <textarea name="" id="txt" cols="30" rows="6">{{
                newData.txt
            }}</textarea>
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
                state: "未套用",
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
            colTitle: [
                "結果編號",
                "人格種類",
                "推薦菜色",
                "分析結果",
                "狀態",
                "",
            ],
            result: [
                {
                    id: 1,
                    personality: "冒險家",
                    txt: `分析原因：對新奇和刺激的渴望使你喜歡嘗試不同的味道和料理、你尋求新的口味體驗、並享受冒烹飪過程。`,
                    state: "套用",
                    productLists: [
                        {
                            name: "西班牙海鮮燉飯",
                            category: "主菜",
                            amount: 1,
                        },
                        {
                            name: "阿根廷燉牛肉",
                            category: "主菜",
                            amount: 1,
                        },
                        {
                            name: "墨西哥辣味雞肉湯",
                            category: "湯品",
                            amount: 1,
                        },
                        {
                            name: "泰式生菜包",
                            category: "沙拉",
                            amount: 1,
                        },
                    ],
                },
                {
                    id: 2,
                    personality: "安逸享受者",
                    txt: "分析原因：你對舒適和享受的追求使你喜歡選擇家常菜和溫和口味的食物。你尋求平衡和放鬆，享受那種讓你感到舒服和滿足的味道。",
                    state: "套用",
                    productLists: [
                        {
                            name: "日本櫻花蝦天婦羅",
                            category: "主菜",
                            amount: 1,
                        },
                        {
                            name: "奶油啤酒蛤蠣",
                            category: "主菜",
                            amount: 1,
                        },
                        {
                            name: "馬來西亞椰奶雞湯",
                            category: "湯品",
                            amount: 1,
                        },
                        {
                            name: "巴西凱撒沙拉",
                            category: "沙拉",
                            amount: 1,
                        },
                    ],
                },
                {
                    id: 3,
                    personality: "創意人格",
                    txt: "分析原因：你的豐富創意和熱情驅使你追求獨特的飲食體驗。你喜歡嘗試新穎的料理和特色小吃，並將食物視為藝術和表達自我的方式。",
                    state: "套用",
                    productLists: [
                        {
                            name: "塔香茄子",
                            category: "主菜",
                            amount: 1,
                        },
                        {
                            name: "中華彗星炒飯",
                            category: "主菜",
                            amount: 1,
                        },
                        {
                            name: "法國洋蔥湯",
                            category: "湯品",
                            amount: 1,
                        },
                        {
                            name: "印度瑪撒拉薯仔沙拉",
                            category: "沙拉",
                            amount: 1,
                        },
                    ],
                },
                {
                    id: 4,
                    personality: "社交達人",
                    txt: "分析原因：你喜歡社交和人際交往，食物在社交場合中扮演重要角色。你喜歡分享美食，享受小吃和下午茶點等輕鬆的社交餐點。",
                    state: "套用",
                    productLists: [
                        {
                            name: "泡椒炒鮮魚",
                            category: "主菜",
                            amount: 1,
                        },
                        {
                            name: "希臘烤羊肉",
                            category: "主菜",
                            amount: 1,
                        },
                        {
                            name: "意大利米蘭湯",
                            category: "湯品",
                            amount: 1,
                        },
                        {
                            name: "糖漬番茄",
                            category: "沙拉",
                            amount: 1,
                        },
                    ],
                },
                {
                    id: 5,
                    personality: "健康控",
                    txt: "分析原因：你對健康和營養的關注使你傾向選擇健康沙拉、素食料理和天然有機食物。你重視身體健康和營養均衡的飲食習慣。",
                    state: "套用",
                    productLists: [
                        {
                            name: "滑嫩番茄蛋",
                            category: "主菜",
                            amount: 1,
                        },
                        {
                            name: "麻婆豆腐",
                            category: "主菜",
                            amount: 1,
                        },
                        {
                            name: "泰式酸辣湯",
                            category: "湯品",
                            amount: 1,
                        },
                        {
                            name: "中東麥麩沙拉",
                            category: "沙拉",
                            amount: 1,
                        },
                    ],
                },
                {
                    id: 6,
                    personality: "情感探索者",
                    txt: "分析原因：你對情感和內心探索感興趣，食物對你來說是情感療癒的一部分。你喜歡享受舒緩心情的甜點和心靈療癒的食物，並創造溫馨的烹飪體驗。",
                    state: "套用",
                    productLists: [
                        {
                            name: "越南河粉湯",
                            category: "主菜",
                            amount: 1,
                        },
                        {
                            name: "法國紅酒燉雞",
                            category: "主菜",
                            amount: 1,
                        },
                        {
                            name: "意大利肉醬千層麵",
                            category: "湯品",
                            amount: 1,
                        },
                        {
                            name: "加拿大蔓越莓野菜沙拉",
                            category: "沙拉",
                            amount: 1,
                        },
                    ],
                },
                {
                    id: 7,
                    personality: "冒險家",
                    txt: `分析原因：對新奇和刺激的渴望使你喜歡嘗試不同的味道和料理、你尋求新的口味體驗、並享受冒烹飪過程。`,
                    state: "未套用",
                    productLists: [
                        {
                            name: "西班牙海鮮燉飯",
                            category: "主菜",
                            amount: 1,
                        },
                        {
                            name: "阿根廷燉牛肉",
                            category: "主菜",
                            amount: 1,
                        },
                        {
                            name: "墨西哥辣味雞肉湯",
                            category: "湯品",
                            amount: 1,
                        },
                        {
                            name: "泰式生菜包",
                            category: "沙拉",
                            amount: 1,
                        },
                    ],
                },
                {
                    id: 8,
                    personality: "安逸享受者",
                    txt: "分析原因：你對舒適和享受的追求使你喜歡選擇家常菜和溫和口味的食物。你尋求平衡和放鬆，享受那種讓你感到舒服和滿足的味道。",
                    state: "未套用",
                    productLists: [
                        {
                            name: "日本櫻花蝦天婦羅",
                            category: "主菜",
                            amount: 1,
                        },
                        {
                            name: "奶油啤酒蛤蠣",
                            category: "主菜",
                            amount: 1,
                        },
                        {
                            name: "馬來西亞椰奶雞湯",
                            category: "湯品",
                            amount: 1,
                        },
                        {
                            name: "巴西凱撒沙拉",
                            category: "沙拉",
                            amount: 1,
                        },
                    ],
                },
                {
                    id: 9,
                    personality: "創意人格",
                    txt: "分析原因：你的豐富創意和熱情驅使你追求獨特的飲食體驗。你喜歡嘗試新穎的料理和特色小吃，並將食物視為藝術和表達自我的方式。",
                    state: "未套用",
                    productLists: [
                        {
                            name: "塔香茄子",
                            category: "主菜",
                            amount: 1,
                        },
                        {
                            name: "中華彗星炒飯",
                            category: "主菜",
                            amount: 1,
                        },
                        {
                            name: "法國洋蔥湯",
                            category: "湯品",
                            amount: 1,
                        },
                        {
                            name: "印度瑪撒拉薯仔沙拉",
                            category: "沙拉",
                            amount: 1,
                        },
                    ],
                },
                {
                    id: 10,
                    personality: "社交達人",
                    txt: "分析原因：你喜歡社交和人際交往，食物在社交場合中扮演重要角色。你喜歡分享美食，享受小吃和下午茶點等輕鬆的社交餐點。",
                    state: "未套用",
                    productLists: [
                        {
                            name: "泡椒炒鮮魚",
                            category: "主菜",
                            amount: 1,
                        },
                        {
                            name: "希臘烤羊肉",
                            category: "主菜",
                            amount: 1,
                        },
                        {
                            name: "意大利米蘭湯",
                            category: "湯品",
                            amount: 1,
                        },
                        {
                            name: "糖漬番茄",
                            category: "沙拉",
                            amount: 1,
                        },
                    ],
                },
                {
                    id: 11,
                    personality: "健康控",
                    txt: "分析原因：你對健康和營養的關注使你傾向選擇健康沙拉、素食料理和天然有機食物。你重視身體健康和營養均衡的飲食習慣。",
                    state: "未套用",
                    productLists: [
                        {
                            name: "滑嫩番茄蛋",
                            category: "主菜",
                            amount: 1,
                        },
                        {
                            name: "麻婆豆腐",
                            category: "主菜",
                            amount: 1,
                        },
                        {
                            name: "泰式酸辣湯",
                            category: "湯品",
                            amount: 1,
                        },
                        {
                            name: "中東麥麩沙拉",
                            category: "沙拉",
                            amount: 1,
                        },
                    ],
                },
                {
                    id: 12,
                    personality: "情感探索者",
                    txt: "分析原因：你對情感和內心探索感興趣，食物對你來說是情感療癒的一部分。你喜歡享受舒緩心情的甜點和心靈療癒的食物，並創造溫馨的烹飪體驗。",
                    state: "未套用",
                    productLists: [
                        {
                            name: "越南河粉湯",
                            category: "主菜",
                            amount: 1,
                        },
                        {
                            name: "法國紅酒燉雞",
                            category: "主菜",
                            amount: 1,
                        },
                        {
                            name: "意大利肉醬千層麵",
                            category: "湯品",
                            amount: 1,
                        },
                        {
                            name: "加拿大蔓越莓野菜沙拉",
                            category: "沙拉",
                            amount: 1,
                        },
                    ],
                },
            ],
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
        };
    },
    methods: {
        searchIdOrPhone() {
            console.log(this.searchInput);
            if (this.searchInput == "") {
                this.searchResult = this.result;
            }
            let stateResult = this.result.filter((item) => {
                return item.state.includes(this.searchInput);
            });
            let personalityResult = this.result.filter((item) => {
                return item.personality.includes(this.searchInput);
            });
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
        truncateText(text, length) {
            if (text.length > length) {
                return text.slice(0, length) + "...";
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
            const gameIdNum = this.result.length + 1;
            return gameIdNum;
        },
    },
    created() {
        this.searchResult = this.result;
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
