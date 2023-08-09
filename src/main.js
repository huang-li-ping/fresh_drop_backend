import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

const app = createApp(App)

import 'bootstrap/js/dist/dropdown';

///基本引入
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

//引入要用的icon
import { faPen } from '@fortawesome/free-solid-svg-icons'
import { faMinus } from '@fortawesome/free-solid-svg-icons'
import { faPlus } from '@fortawesome/free-solid-svg-icons'
library.add(faPen, faMinus, faPlus)

//切換router後頁面跳到最上面
router.afterEach(() => {
    window.scrollTo(0, 0);
});

//全域引用axios
import axios from 'axios';
import VueAxios from 'vue-axios'
const apiURL = 'http://localhost:8888/'
app.config.globalProperties.$url = apiURL


app.use(store).use(router).use(VueAxios, axios).component('font-awesome-icon', FontAwesomeIcon).mount('#app')
