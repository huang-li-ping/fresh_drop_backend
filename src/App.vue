<template>
    <router-view></router-view>
</template>

<script>

export default {
    name: "HomeView",
    data() {
        return {};
    },
    methods: {},
    watch: {
        "$route.path": {
            handler: function () {
                if (this.$route.path !== '/' && !this.$store.state.isLogin) {
                    this.$router.push('/')
                    alert('請先登入')
                }
            },
            deep:true
        }
    },
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
