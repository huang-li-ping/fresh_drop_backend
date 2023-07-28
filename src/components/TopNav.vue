<template>
    <nav class="navbar">
        <a href="#">
            <img src="../assets/images/logo/logo.png" alt="logo" />
        </a>
        <span>後台管理</span>
        <button class="btn btn-outline-light" type="button">登出</button>
    </nav>
</template>
<style lang="scss">
.navbar {
    display: flex;
    align-items: center;
    padding: 0px 20px;
    width: 100%;
    background-color: $primary;

    img {
        max-width: 70px;
        height: auto;
    }

    span {
        margin-left: 20px;
        color: #fff;
        font-size: 20px;
        font-weight: bold;
    }

    button {
        margin-left: auto;
    }
}
</style>
