import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

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

createApp(App).use(store).use(router).component('font-awesome-icon', FontAwesomeIcon).mount('#app')
