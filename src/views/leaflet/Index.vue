<style>
.list-leaflet {
  box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px;
  border: none;
  padding: 0.4rem 0.3rem;
}

.list-leaflet span {
  font-size: 20px;
  font-weight: 600;
}

#search-leaflet {
  padding-top: 0px;
  margin-top: -3.7rem;
  padding-bottom: 0.5rem;
}

.btn-view {
  width: 80%;
  margin-right: 5px;
}

.hero {
  height: 45vh !important;
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
    <div class="container-fluid position-relative cs-carousel">
      <div class="row gy-5">
        <div class="col-lg-12 p-0">
          <Carousel>
            <Slide
              v-for="slide in 10"
              :key="slide"
            >
              <div class="item img-item carousel__item">
                <div class="carousel-cover container">
                  <h3 class="carousel-title">Rumah Sakit <span class="carousel-gs">Graha Sehat</span></h3>
                  <p class="carousel-subtitle">Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                    Distinctio
                    repellat placeat ipsum id perferendis</p>
                </div>
                <div class="cvr-img">
                  <img
                    :src="cItem"
                    class="img-fluid"
                    data-aos="zoom-out"
                    data-aos-delay="100"
                  >
                </div>
              </div>
            </Slide>

            <template #addons>
              <Navigation />
              <Pagination />
            </template>
          </Carousel>
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

  <section style="padding: 10px 0;">
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

import { Carousel, Navigation, Pagination, Slide } from "vue3-carousel";
import cItem from "@/assets/img/bg-1.jpg";

export default {
  components: {
    Carousel,
    Slide,
    Pagination,
    Navigation,
    CariLeaflet,
    Detail,
  },
  data() {
    return {
      cItem,
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