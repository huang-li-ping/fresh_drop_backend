<template>
    <form class="login_box">
        <img src="@/assets/images/logo/logo.png" alt="">
        <legend>Welcome back !</legend>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">帳號</span>
            <input type="text" class="form-control" placeholder="" aria-label="請輸入帳號"
                    aria-describedby="basic-addon1" v-model="account">
        </div>
        <div class="input-group mb-4">
            <span class="input-group-text" id="basic-addon1">密碼</span>
            <input type="text" class="form-control" placeholder="" aria-label="請輸入密碼"
                    aria-describedby="basic-addon1" v-model="psw">
        </div>
        <button class="btn btn-primary" @click.prevent="employeeLogin">登入</button>
    </form>
</template>
<script>
export default {
    data() {
        return {
            account: '12345',
            psw:'12345',
        }
    },
    methods: {
        employeeLogin() {
            
            let url = `${this.$url}employeeLogin.php`
            let params = new URLSearchParams()
            params.append("account", this.account)
            params.append("psw", this.psw)
            this.axios.post(url, params).then(res => {
                alert(res.data)
                if (res.data[0] == '登入成功') {
                    this.$store.state.isLogin = true
                    this.$router.push('/backhome')
                } 
            }).catch(err => {
                console.log(err);
            })
        },
    }
}
</script>
<style lang="scss">
    @import "@/assets/scss/page/login.scss";
</style>