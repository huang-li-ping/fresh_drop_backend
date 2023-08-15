import { createStore } from "vuex";

export default createStore({
    state: {
        memDetail: [],
        isLogin: false,
        ordDetail:{},
        
    },
    getters: {},
    mutations: {
        sendMemDetail(state, data) {
            state.memDetail = data;
            sessionStorage.setItem("detail_cusNo", data[0].cus_no);
        },
        sendOrdDetail(state, data) {
            state.ordDetail = data;
            sessionStorage.setItem("detail_ordNo", data.ord_no);
        },
    },
    actions: {},
    modules: {},
});
