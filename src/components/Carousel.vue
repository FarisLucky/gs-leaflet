<template></template>
<script>

import { Carousel, Navigation, Pagination, Slide } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'
export default {
    name: 'Carousel',
    components: {
        Carousel,
        Slide,
        Pagination,
        Navigation,
    }
}
</script>

<style>
.carousel__slide {
    padding: 30px;
}

.carousel__prev,
.carousel__next {
    box-sizing: content-box;
    border: 5px solid white;
}
</style>