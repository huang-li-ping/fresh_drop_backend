import { createStore } from "vuex";

export default createStore({
    state: {
        memDetail: [],
        isLogin: false,
    },
    getters: {},
    mutations: {
        sendMemDetail(state, data) {
            state.memDetail = data;
            sessionStorage.setItem("detail_cusNo", data[0].cus_no);
        },
    },
    actions: {},
    modules: {},
});
