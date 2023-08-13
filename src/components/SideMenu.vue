<template>
    <div class="col-3">
        <div class="sidebar">
            <ul>
                <router-link v-for=" item in menu" :key="item.link" 
                    :to="item.link" class="item" :class="{'active':nowPage === item.link }" 
                    @click="nowPage=item.link">
                    <span>{{ item.title }}</span>
                </router-link>
                
            </ul>
        </div>
    </div>
</template>
<script>

export default {
    name: 'SideMenu',
    // components: {
    //   MainHeader,
    // },
    data() {
        return {
            nowPage: '',
            menu: [
                {
                    link: '/order',
                    title:'訂單管理'
                },
                {
                    link: '/member',
                    title:'會員資料管理'
                },
                {
                    link: '/recipe',
                    title:'菜色管理'
                },
                {
                    link: '/ingred',
                    title:'食材管理'
                },
                {
                    link: '/giftcard',
                    title:'禮物卡管理'
                },
                {
                    link: '/opinion',
                    title:'烹飪心得管理'
                },
                {
                    link: '/report',
                    title:'烹飪檢舉管理'
                },
                {
                    link: '/faq',
                    title:'FAQ管理'
                },
                {
                    link: '/game',
                    title:'遊戲結果管理'
                },
                {
                    link: '/employee',
                    title:'管理員帳號管理'
                },
            ]
        };
    },
    created() {
        this.nowPage = this.$route.path
    },
    methods: {

    },
}
</script>
<style lang="scss">
.sidebar {
    height: 100%;
    border-right: 3px solid $primary;

    ul {
        display: flex;
        flex-direction: column;
        padding-left: 0px;
        padding-right: 0px;
        // padding: 20px;

        .item {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            height: 50px;
            text-align: start;
            margin-left: auto;
            margin-right: auto;
            width: 100%;
            text-decoration: none;
            font-size: 20px;

            span {
                padding-left: 30px;
            }

            &:hover {
                background-color: $primary;
                color: #fff;
                transition: background-color 0.2s ease-out;
            }

            &.active {
                background-color: $primary;
                color: #fff;
            }
        }
    }
}
</style>
