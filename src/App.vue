<template>
    <router-view></router-view>
</template>

<script>
import SideMenu from "@/components/SideMenu.vue";
import TopNav from "@/components/TopNav.vue";

export default {
    name: "HomeView",
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

#app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
    display: flex;
    flex-direction: column;
    height: 100vh;
}

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
