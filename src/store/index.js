import { createStore } from "vuex";
import axios from "axios";

export default createStore({
    state: {
        memDetail: [],
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
