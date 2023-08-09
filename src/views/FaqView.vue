<template>
    <PageTitle :title="'FAQ管理'" />
    <div class="game_container">
        <div class="mb-3 ps-3 pe-3 search_bar_group">
            <div class="d-flex justify-content-between">
                <div class="input-group" style="width: fit-content;">
                    <span class="input-group-text">搜尋結果</span>
                    <input type="text" class="form-control" placeholder="請輸入分類或狀態" @input="searchIdOrPhone"
                        v-model="searchInput" />
                </div>

                <!-- 新增 -->
                <div class="create">
                    <button class="btn btn-primary create-btn" @click="openModal(null)" type="button"
                        style="margin-left: auto; color: #fff">新增問答</button>
                </div>
            </div>
        </div>
        <!-- 表格 -->
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="(item, index) in colTitle" :key="index">{{ item }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in showData" :key="index">

                    <td>{{ item.type }}</td>
                    <td>{{ truncateText(item.questions, 6) }}</td>
                    <td>{{ truncateText(item.answers, 6) }}</td>
                    <td>{{ item.state }}</td>
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
            <select v-model="newData.state">
                <option value="套用">套用</option>
                <option value="未套用">未套用</option>
            </select>
        </label>


        <label for="">分類:<select v-model="newData.type">
                <option value="常見問題">常見問題</option>
                <option value="會員註冊">會員註冊</option>
                <option value="付款問題">付款問題</option>
                <option value="寄送問題">寄送問題</option>
                <option value="購物相關">購物相關</option>
                <option value="訂單問題">訂單問題</option>
                <option value="禮物卡相關">禮物卡相關</option>
                <option value="退換貨問題">退換貨問題</option>
            </select> </label>


        <label for="" style="display: flex;">標題:
            <textarea name="" id="" cols="30" rows="3">{{ newData.questions }}</textarea>
        </label>
        <label for="" style="display: flex;">內容:
            <textarea name="" id="" cols="30" rows="10">{{ newData.answers }}</textarea>
        </label>
        <button class="delete">刪除</button>
        <button class="archive">存檔</button>

        <!-- 關閉按鍵 -->
        <button class="xmark btn btn-outline-secondary " @click="closeModal">
            x
        </button>
    </div>
</template>
<script>
import PageTitle from '@/components/PageTitle.vue';

import PageComponent from "@/components/PageComponent.vue";
export default {
    name: 'FaqView',
    components: {
        PageComponent,
        PageTitle,
    },
    data() {
        return {
            showModal: false,
            presetData: {
                id: null,
                type: null,
                state: '未套用',
                questions: ' ',
                answers: ' ',
                open: false
            },
            newData: null,
            showData: [],
            searchInput: '',
            searchResult: [],
            colTitle: ["分類", "標題", "內容", "狀態", ""],
            faq: [
                {
                    id: 1,
                    type: '常見問題',
                    state: '套用',
                    questions: '機車外務人員將貨送到管理室，結果忘了取貨，隔天菜都壞了，能換嗎？',
                    answers: '我們十分遺憾您發生的狀況！但因生鮮蔬果、魚肉等屬易腐之消耗性產品，由於產品屬性特殊且有保存問題，除因產品本身有瑕疵可退貨外，一經拆封、食用或消費者造成之外盒變形、失溫或保存不良導致變質，要請您諒解無法辦理退貨退款。',
                    open: false
                },
                {
                    id: 2,
                    type: '常見問題',
                    state: '套用',
                    questions: '網站上看到的都是冷凍的魚和肉，這新鮮嗎？',
                    answers: '肉品的部分，都是在具有衛生安全合格的CAS工廠裡宰殺並分切好，然後立即急速冷凍，真空包裝。但傳統市集裡的多半是半夜宰殺後，就掛在貨車上，在路上跑個幾小時，丟到肉攤上，等待老闆六、七點來分切，然後賣到中午或下午，看到這裡，還新鮮嗎？魚的部分，確定躺在冰塊上的還是「活」魚嗎？魚一死亡，魚腹內腐敗的快速程度絕對超乎你我的想像，一拿掉內臟誰還知道呢？歡迎您親自試試就知道，肉質的口感，最直接的嗅覺，新鮮由您自行判斷便知曉！',
                    open: false
                },
                {
                    id: 3,
                    type: '常見問題',
                    state: '套用',
                    questions: '太過度包裝了吧？',
                    answers: '有些顧客會發現我們的菜況比很多生鮮超市更新鮮耐保存、物品不容易破損，而且免運門檻低。這些都要歸功於我們設計的混溫層包裝，透過保冷劑、舒服多袋以及白色不易吸熱的紙箱及封膜，能讓我們即便以機車常溫配送，在炎熱的夏天仍然可於配送的4小時內保持食材的新鮮。不必仰賴高成本、高耗能又不便捷的冷藏貨運一一配送。',
                    open: false
                },
                {
                    id: 4,
                    type: '會員註冊',
                    state: '套用',
                    questions: '我已經是會員，忘記密碼怎麼辦？',
                    answers: '您可以至【會員登入】頁面，選擇【忘記密碼】按鈕，系統會發送一組新密碼的簡訊到您的手機上，登入後再重新修改密碼即可。',
                    open: false
                },
                {
                    id: 5,
                    type: '會員註冊',
                    state: '套用',
                    questions: '如何修改個人資料？',
                    answers: '請您先登入會員，再透過【會員中心】，進入【個人資料修改】頁面。將您個人資料補齊或是修改成功後，再點選【儲存】，即可完成。',
                    open: false
                },
                {
                    id: 6,
                    type: '會員註冊',
                    state: '套用',
                    questions: '註冊會員一定要填寫E-mail嗎？',
                    answers: '不一定哦，如果您沒有E-mail也可以成功加入會員。不過有E-mail會更方便唷，您也可以先加入會員，等之後再補上您的E-mail哦！',
                    open: false
                },
                {
                    id: 7,
                    type: '付款問題',
                    state: '套用',
                    questions: '有甚麼付款方式？',
                    answers: '線上刷卡&貨到付款',
                    open: false
                },
                {
                    id: 8,
                    type: '付款問題',
                    state: '套用',
                    questions: '運費如何計算？',
                    answers: '單筆結帳金額滿499元(含)以上即免運費，不足將收取120元運費。',
                    open: false
                },
                {
                    id: 9,
                    type: '寄送問題',
                    state: '套用',
                    questions: '購買商品訂購之後多久可收到？',
                    answers: '中午12:00前完成訂購，隔日下午14:00~18:00前完成配送。',
                    open: false
                },
                {
                    id: 10,
                    type: '寄送問題',
                    state: '套用',
                    questions: '若不在配送區域，可以購買商品嗎？',
                    answers: '因此，非配送區的朋友要說聲抱歉。',
                    open: false
                },
                {
                    id: 11,
                    type: '寄送問題',
                    state: '套用',
                    questions: '商品寄送經過長途跋涉，還能維持新鮮嗎？',
                    answers: '商品全程經過冷凍配送，外包裝也有經過真空及保冷的特殊處理，可以放心食用喔。',
                    open: false
                },
                {
                    id: 12,
                    type: '購物相關',
                    state: '套用',
                    questions: '如何確認訂單是否有訂購成功呢？',
                    answers: '您可以登入會員，進入網站上方【會員中心】的【訂購紀錄】查詢。有下單成功的訂單，會顯示在訂購紀錄上，如果都沒有顯示，表示您當初未完成訂單或訂購失敗。',
                    open: false
                },
                {
                    id: 13,
                    type: '購物相關',
                    state: '套用',
                    questions: '當日配送區域有哪些？',
                    answers: `台北市:
                中山區、大同區、中正區、大安區、松山區、士林區、萬華區、內湖區、信義區`,
                    open: false
                },



                {
                    id: 14,
                    type: '訂單問題',
                    state: '套用',
                    questions: '收到貨怎麼沒有附發票呢？',
                    answers: '已全面採用無實體電子發票。依財政部規定需提供共通載具(手機條碼、自然人憑證)，因此在本站可選擇無載具或手機條碼或自然人憑證的載具方式去儲存電子發票。',
                    open: false
                },
                {
                    id: 15,
                    type: '訂單問題',
                    state: '套用',
                    questions: '請問我要怎麼確定我有訂購成功呢？',
                    answers: '您可以登入會員，進入網站上方【會員中心】的【訂購紀錄】查詢。有下單成功的訂單，會顯示在訂購紀錄上，如果都沒有顯示，表示您當初未完成訂單或訂購失敗。',
                    open: false
                },
                {
                    id: 16,
                    type: '訂單問題',
                    state: '套用',
                    questions: '哪裡可以查看我的出貨日期呢？',
                    answers: '您可以登入會員，進入網站上方【會員中心】的【訂購紀錄】查詢出貨日期哦。',
                    open: false
                },
                {
                    id: 17,
                    type: '訂單問題',
                    state: '套用',
                    questions: '訂單成立後是否可以修改訂單商品及數量？',
                    answers: '已下定的訂單無法修改，如需調整訂單內容請直接連繫客服人員協助修改訂單內容!',
                    open: false
                },
                {
                    id: 18,
                    type: '訂單問題',
                    state: '套用',
                    questions: '訂單成立後是否可以取消？',
                    answers: '訂單成立後即進入出貨流程，所以無法取消訂單!',
                    open: false
                },



                {
                    id: 19,
                    type: '禮物卡相關',
                    state: '套用',
                    questions: '我的禮物卡如何激活和使用？',
                    answers: '通常情況下，您的禮物卡在購買後會自動激活。如果您收到一張未激活的禮物卡，請聯繫我們的客戶服務部門以獲取幫助。',
                    open: false
                },
                {
                    id: 20,
                    type: '禮物卡相關',
                    state: '套用',
                    questions: '我可以在您的電商網站上使用禮物卡嗎？',
                    answers: '是的，您可以在我們的電商網站上使用禮物卡。我們提供禮物卡作為購物的付款方式。',
                    open: false
                },
                {
                    id: 21,
                    type: '禮物卡相關',
                    state: '套用',
                    questions: '我可以將禮物卡的餘額轉讓給其他人嗎？',
                    answers: '通常情況下，禮物卡的餘額是不可轉讓的。禮物卡通常僅限於原始購買者使用或指定的收禮者使用。請確保您在購買禮物卡時了解相關的使用條款和限制。',
                    open: false
                },
                {
                    id: 22,
                    type: '退換貨問題',
                    state: '套用',
                    questions: '如何退換貨?',
                    answers: '若退換貨的原因是產品本身的瑕疵，可歸咎於本公司的過失，請於24H內透過LINE聯繫客服人員。',
                    open: false
                },
                {
                    id: 23,
                    type: '退換貨問題',
                    state: '套用',
                    questions: '換貨的運費由誰承擔？',
                    answers: '在正常情況下，如果換貨是由於商品損壞、缺陷或與訂購不符，我們將承擔換貨的運費。這包括退回損壞或有問題的商品以及重新發送新的商品的運費。',
                    open: false
                },
                {
                    id: 24,
                    type: '退換貨問題',
                    state: '套用',
                    questions: '我可以換成不同的商品嗎？',
                    answers: '通常情況下，如果您符合換貨的條件，您可以選擇將商品換成不同的商品。換貨的可行性取決於庫存狀況和可用性。請聯繫我們的客戶服務部門，向他們提出換貨要求，並告知您希望換成的商品',
                    open: false
                },
                {
                    id: 25,
                    type: '退換貨問題',
                    state: '未套用',
                    questions: '我可以換成不同的商品嗎？',
                    answers: '通常情況下，如果您符合換貨的條件，您可以選擇將商品換成不同的商品。換貨的可行性取決於庫存狀況和可用性。請聯繫我們的客戶服務部門，向他們提出換貨要求，並告知您希望換成的商品',
                    open: false
                },
                {
                    id: 26,
                    type: '退換貨問題',
                    state: '未套用',
                    questions: '我可以換成不同的商品嗎？',
                    answers: '通常情況下，如果您符合換貨的條件，您可以選擇將商品換成不同的商品。換貨的可行性取決於庫存狀況和可用性。請聯繫我們的客戶服務部門，向他們提出換貨要求，並告知您希望換成的商品',
                    open: false
                }



            ],
        };
    },
    methods: {
        searchIdOrPhone() {
            console.log(this.searchInput);
            if (this.searchInput == '') {
                this.searchResult = this.faq
            }
            let typeResult = this.faq.filter(item => {
                return item.type.includes(this.searchInput)
            })
            let stateResult = this.faq.filter(item => {
                return item.state.includes(this.searchInput)
            })
            if (typeResult.length > 0) {
                this.searchResult = typeResult
            } else if ((stateResult.length > 0)) {
                this.searchResult = stateResult
            }
        },
        //控制顯示字數 多的用"..."省略
        truncateText(text, length) {
            if (text.length > length) {
                return text.slice(0, length) + '...';
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
        getPageData(data) {
            this.showData = data
        },
    },
    created() {
        this.searchResult = this.faq
    },



};
</script>

<style lang="scss">
// @import 'bootstrap/dist/css/bootstrap.min.css';
// @import '@/assets/scss/all.scss';
// @import "@/assets/scss/page/ingredients.scss";

.show_modal {
    border: 3px solid #1F8D61;
    border-radius: 20px;
    width: fit-content;
    padding: 30px;
    position: relative;
    position: fixed;
    font-weight: 700;
    background-color: #FFF7EA;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    overflow: auto;
    height: fit-content;

    .xmark {
        right: 5px;
        top: 5px;
        position: absolute;
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
        background-color: #FFF7EA;
        border: #1F8D61 1px solid;
        border-radius: 20px;
        width: 90%;
        margin: 10px auto 0;
    }
}
</style>
