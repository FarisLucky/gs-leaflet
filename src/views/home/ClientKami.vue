<template>
    <swiper :modules="modules" :slides-per-view="6" :space-between="50" @swiper="onSwiper" @slideChange="onSlideChange"
        :autoplay="{
            delay: 2000,
            disableOnInteraction: false,
        }">
        <template v-for="idx in 12">
            <swiper-slide><img :src="client1" class="img-fluid" alt=""></swiper-slide>
        </template>
    </swiper>
</template>
<script>
// Import Swiper Vue.js components
import { A11y, Autoplay } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import client1 from "@/assets/img/clients/client-1.png"

// Import Swiper styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';

export default {
    components: {
        Swiper,
        SwiperSlide,
    },
    setup() {
        const onSwiper = (swiper) => {
            console.log(swiper);
        };
        const onSlideChange = () => {
            console.log('slide change');
        };
        return {
            onSwiper,
            onSlideChange,
            client1,
            modules: [A11y, Autoplay],
        };
    },
};
</script>