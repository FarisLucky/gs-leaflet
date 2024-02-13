<style scoped>
.list-leaflet {
  box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px;
  border: none;
  padding: 0.4rem 0.3rem;
}

.list-leaflet span {
  font-size: 20px;
  font-weight: 600;
}

.card-body-cs {
  height: 13rem;
}

.card-title {
  overflow: hidden;
  text-overflow: ellipsis;
  height: 2.7rem;
}

.card-subtitle {
  overflow: hidden;
  text-overflow: ellipsis;
  height: 5.7rem;
}
</style>
<template>
  <!-- ======= Hero Section ======= -->
  <section
    id="hero"
    class="hero"
  >
    <div class="container container-cs position-relative h-100">
      <div class="mb-1 mt-3 jumbotron row mx-0">
        <div class="col-lg-6 p-3 cover">
          <span class="title">RS GRAHA SEHAT</span>
          <span class="subtitle">Kumpulan Leaflet RS Graha Sehat</span>
        </div>
        <div class="col-lg-6 cover-img">
          <img
            :src="img"
            class="jumbotron-img"
            style="max-width: 250px;"
          >
        </div>
      </div>
    </div>
  </section>

  <section
    id="search-leaflet"
    style="overflow: visible;"
  >
    <div class="container container-cs">
      <CariLeaflet />
    </div>
  </section>

  <section style="padding: 0;">
    <div class="container container-cs">
      <router-view v-slot="{ Component }">
        <transition name="slide-fade">
          <component :is="Component" />
        </transition>
      </router-view>
    </div>
  </section>
</template>

<script>
import Detail from "./Detail.vue";
import CariLeaflet from "@/views/leaflet/CariLeaflet.vue";
import { useLeafletStore } from "@/stores/leaflets";

import { Carousel, Navigation, Pagination, Slide } from "vue3-carousel";
import cItem from "@/assets/img/bg-1.jpg";
import { mapState } from "pinia";
import img from "@/assets/img/book-material.png";

export default {
  components: {
    Carousel,
    Slide,
    Pagination,
    Navigation,
    CariLeaflet,
    Detail,
  },
  computed: {
    ...mapState(useLeafletStore, ["data"]),
  },
  data() {
    return {
      cItem,
      img,
    };
  },
};
</script>

<style>
.carousel {
  text-align: left;
}

.carousel__item {
  min-height: 200px;
  width: 100%;
  background-color: var(--vc-clr-primary);
  color: var(--vc-clr-white);
  font-size: 20px;
  border-radius: 8px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.carousel__slide {
  padding: 0px;
}

.carousel__prev,
.carousel__next {
  box-sizing: content-box;
  border: 5px solid white;
}
</style>