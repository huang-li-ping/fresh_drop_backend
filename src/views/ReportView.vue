<template>
    <PageTitle :title="'烹飪檢舉管理'" />
    <div class="report_container">
        <!-- 搜尋框 -->
        <div class="mb-3 ps-3 pe-3 search_bar_group">
            <div class="d-flex justify-content-between">
                <div class="input-group">
                    <span class="input-group-text">搜尋菜色</span>
                    <input type="text" class="form-control" placeholder="請輸入菜色" @input="searchIdOrPhone"
                        v-model="searchInput" />
                    <div class="btn btn-outline-primary" @click="searchIdOrPhone">搜尋</div>
                </div>
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
                <td>{{ item.report_no }}</td>
                <td>{{ item.opinion_no }}</td>
                <td>{{ item.member_fk }}</td>
                <td>
                    <div class="recipe_pic">
                        <img :src="require(`@/assets/images/product/${item.report_pic}`)" alt="">
                    </div>
                </td>
                <td>{{ truncateText(item.reason, 4) }}</td>
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
    <div class="report_show_modal d-flex flex-column align-items-start gap-2" v-if="showModal">
        <h4>被檢舉內容：</h4>
        <div class="report_content">
            <div class="report_pic">
                <img :src="require(`@/assets/images/product/${newData.report_pic}`)" alt="">
            </div>
            <div class="report_name">
                <div class="report_member">
                    <div class="report_name_pic">
                        <img src="/chd102/g2/data_images/logo/1.png" alt="">
                    </div>
                    <div class="report_me">
                        <h6>{{ newData.member }}</h6>
                    </div>
                </div>
                <div class="report_text">
                    <p>{{ newData.experience }}</p>
                </div>
            </div>
        </div>
        <div class="report_text">
            <p>檢舉原因：{{ newData.reason }}</p>

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
import PageComponent from '@/components/PageComponent.vue';
import PageTitle from '@/components/PageTitle.vue';

export default {
    name: 'ReportView',
    components: {
        PageComponent,
        PageTitle,
    },
    data() {
        return {
            colTitle: ["檢舉編號", "心得分享編號", "會員編號", "照片", "檢舉原因", "日期", "狀態", "", ""],
            reportData: [],
            showModal: false,
            newData: [],
            searchInput: "",
            searchResult: [],
            showData: [],
        };
    },
    methods: {
        //串接ingred資料庫        
        getreportData() {
            let url = `${this.$url}report.php`
            this.axios.get(url).then(res => {
                this.reportData = res.data
            }).catch(err => {
                console.log(err);
            })
        },
        searchIdOrPhone() {
            if (this.searchInput == "") {
                this.searchResult = this.reportData;
            }
            let idResult = this.reportData.filter((item) => {
                return item.report_no.includes(this.searchInput);
            });
            let nameResult = this.reportData.filter((item) => {
                return item.member_fk.includes(this.searchInput);
            });
            if (idResult.length > 0) {
                this.searchResult = idResult;
            } else if (nameResult.length > 0) {
                this.searchResult = nameResult;
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
        this.searchResult = this.reportData;
    },
    //串接ingred資料庫
    watch: {
        reportData: {
            handler: function () {
                console.log('watch');
                this.searchResult = this.reportData;
            },
            deep: true,
        },

    },
    mounted() {
        //串接ingred資料庫
        this.getreportData()
    },
};
</script>

<style lang="scss">
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
.report_show_modal {
    position: fixed;
    left: 50%;
    transform: translate(-50%, -50%);
    top: 50%;
    border: 3px solid #1F8D61;
    border-radius: 20px;
    width: fit-content;
    padding: $sp2;
    position: relative;
    position: fixed;
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

    .report_content {
        border: 3px solid #1F8D61;
        width: 400px;
        display: flex;

        .report_pic {
            width: 150px;
            margin: 20px;
        }

        img {
            width: 100%;
            border-radius: 20px;
        }
    }

    .report_name {
        margin: auto;
        display: block;
        width: 150px;

        .report_member {
            display: flex;
            text-align: left;

            .report_name_pic {
                width: 60px;

                img {
                    width: 100%;
                }
            }
        }

        .report_me {
            h6 {
                line-height: 60px;
                font-size: 20px;
            }
        }

        .report_text {
            text-align: left;
            margin-top: 18px;
        }
    }

    .button_bt {
        display: flex;
        margin: auto;
        gap: 10px;
        width: 400px;

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

td {
    align-items: center;
    vertical-align: middle;
}

.recipe_pic {
    display: block;
    margin: auto;
    width: 80px;

    img {
        width: 100%;
    }
}</style>

