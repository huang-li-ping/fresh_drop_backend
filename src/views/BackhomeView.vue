<template>
    <!-- 導覽列 -->
    <TopNav />
    <div class="container-fluid back_container">
        <!-- 側邊欄 -->
        <div class="row">
            <SideMenu />

            <!-- 內容 -->
            <div class="col-9">
                <div class="main">

                    <router-view />
                    
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SideMenu from "@/components/SideMenu.vue";
import TopNav from "@/components/TopNav.vue";

export default {
    name: "BackhomeView",
    components: {
        SideMenu,
        TopNav,
    },
    data() {
        return {};
    },
    methods: {},
};
</script>

<style lang="scss">
// @import "~bootstrap/scss/bootstrap";
// @import '@/assets/scss/all.scss';
@import "@/assets/scss/layout/home.scss";

nav {
    padding: 30px;

    a {
        font-weight: bold;
        color: #2c3e50;

        &.router-link-exact-active {
            color: #42b983;
        }
    }
}

</style>
