<template>
    <div class="col-3">
        <div class="sidebar">
            <ul>
                <router-link to="/order" class="item"><span>訂單管理</span></router-link>
                <router-link to="/member" class="item"><span>會員資料管理</span></router-link>
                <router-link to="recipe" class="item"><span>菜色管理</span></router-link>
                <router-link to="/ingred" class="item active"><span>食材管理</span></router-link>
                <router-link to="/giftcard" class="item"><span>禮物卡管理</span></router-link>
                <router-link to="/opinion" class="item"><span>烹飪心得管理</span></router-link>
                <router-link to="/faq" class="item"><span>FAQ管理</span></router-link>
                <router-link to="/game" class="item"><span>遊戲結果管理</span></router-link>
                <router-link to="/report" class="item"><span>檢舉管理</span></router-link>
                <router-link to="#" class="item"><span>管理員帳號管理</span></router-link>
            </ul>
        </div>
    </div>
</template>

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
