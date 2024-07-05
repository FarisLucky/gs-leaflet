import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'
import vSelect from "vue-select";
import VueAwesomePaginate from "vue-awesome-paginate";
import VueProgressBar from "@aacassandra/vue3-progressbar";
import easySpinner from 'vue-easy-spinner';
import VueFullscreen from 'vue-fullscreen'
import VueLazyLoad from 'vue3-lazyload'

import 'vue-awesome-paginate/dist/style.css';
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap-icons/font/bootstrap-icons.min.css'
import '@/assets/css/main.css'
import '@/assets/css/custom.css'
import '@/styles/custom.css'
import 'bootstrap/dist/js/bootstrap.js'
import 'aos/dist/aos.css'
import 'vue3-carousel/dist/carousel.css'
import 'vue-select/dist/vue-select.css';

const options = {
    color: "#34495e",
    failedColor: "#874b4b",
    thickness: "8px",
    transition: {
        speed: "0.5s",
        opacity: "0.7s",
        termination: 300,
    },
    autoRevert: true,
    location: "top",
    inverse: false,
};

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(VueProgressBar, options)
app.use(VueAwesomePaginate)
app.use(easySpinner, {
    /*options*/
    prefix: 'easy',
})
app.use(VueLazyLoad)
app.component("v-select", vSelect);
app.use(VueFullscreen)

app.mount('#app')
