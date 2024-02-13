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
                  <p class="carousel-subtitle">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Distinctio
                    repellat placeat ipsum id perferendis</p>
                </div>
                <div class="cvr-img">
                  <img
                    :src="cItem"
                    class="img-fluid"
                    alt=""
                    data-aos="zoom-out"
                    data-aos-delay="100"
                  >
                </div>
              </div>
              <!-- <div class="carousel__item cvr-img">{{ slide }}</div> -->
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

  <section id="search_dokter">
    <div class="container container-cs">
      <!-- <TemukanDokter /> -->
    </div>
  </section>
  <!-- End Hero Section -->

  <main id="main">

    <section id="spesialis_kami">
      <div class="container">
        <SpesialisKami />
      </div>
    </section>

    <!-- ======= Clients Section ======= -->
    <section
      id="clients"
      class="clients"
    >
      <div
        class="container"
        data-aos="zoom-out"
      >
        <div class="cs-header mb-0">
          <h4>Client Asuransi Kami</h4>
        </div>
        <ClientKami />
        <!-- <div class="clients-slider swiper">
          <div class="swiper-wrapper align-items-center">
            <div class="swiper-slide"><img src="assets/img/clients/client-1.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-2.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-3.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-4.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-5.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-6.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-7.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-8.png" class="img-fluid" alt=""></div>
          </div>
        </div> -->
      </div>
    </section><!-- End Clients Section -->

    <!-- ======= Call To Action Section ======= -->
    <section
      id="intro"
      class="call-to-action"
    >
      <div
        class="container text-center"
        data-aos="zoom-out"
      >
        <h3>Profil RS <span class="text-primary">Graha Sehat</span></h3>
        <a
          href="https://www.youtube.com/watch?v=gg5gZDviOVo"
          class="glightbox play-btn"
        ></a>
        <p>Video profil perkenala graha sehat.
        </p>
        <!-- <a class="cta-btn" href="#">Play</a> -->
      </div>
    </section><!-- End Call To Action Section -->

    <!-- ======= Our Services Section ======= -->
    <section
      id="layanan_kami"
      class="services"
    >
      <LayananKami />
    </section><!-- End Our Services Section -->

    <!-- ======= About Us Section ======= -->
    <section
      id="berita"
      class="berita"
    >
      <div
        class="container"
        data-aos="fade-up"
      >
        <Berita />
      </div>
    </section><!-- End About Us Section -->

    <!-- ======= Frequently Asked Questions Section ======= -->
    <section
      id="faq"
      class="faq"
    >
      <div
        class="container"
        data-aos="fade-up"
      >
        <div class="row gy-4">
          <div class="col-lg-4">
            <div class="content px-xl-5">
              <h3>Frequently Asked <strong>Questions</strong></h3>
              <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua. Duis aute irure dolor in reprehenderit
              </p>
            </div>
          </div>
          <div class="col-lg-8">
            <div
              class="accordion accordion-flush"
              id="faqlist"
              data-aos="fade-up"
              data-aos-delay="100"
            >

              <div class="accordion-item">
                <h3 class="accordion-header">
                  <button
                    class="accordion-button collapsed"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq-content-1"
                  >
                    <span class="num">1.</span>
                    Non consectetur a erat nam at lectus urna duis?
                  </button>
                </h3>
                <div
                  id="faq-content-1"
                  class="accordion-collapse collapse"
                  data-bs-parent="#faqlist"
                >
                  <div class="accordion-body">
                    Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet non curabitur
                    gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non.
                  </div>
                </div>
              </div><!-- # Faq item-->

              <div class="accordion-item">
                <h3 class="accordion-header">
                  <button
                    class="accordion-button collapsed"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq-content-2"
                  >
                    <span class="num">2.</span>
                    Feugiat scelerisque varius morbi enim nunc faucibus a pellentesque?
                  </button>
                </h3>
                <div
                  id="faq-content-2"
                  class="accordion-collapse collapse"
                  data-bs-parent="#faqlist"
                >
                  <div class="accordion-body">
                    Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id
                    donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque
                    elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.
                  </div>
                </div>
              </div><!-- # Faq item-->

              <div class="accordion-item">
                <h3 class="accordion-header">
                  <button
                    class="accordion-button collapsed"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq-content-3"
                  >
                    <span class="num">3.</span>
                    Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi?
                  </button>
                </h3>
                <div
                  id="faq-content-3"
                  class="accordion-collapse collapse"
                  data-bs-parent="#faqlist"
                >
                  <div class="accordion-body">
                    Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus pulvinar
                    elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum tellus pellentesque
                    eu tincidunt. Lectus urna duis convallis convallis tellus. Urna molestie at elementum eu facilisis
                    sed odio morbi quis
                  </div>
                </div>
              </div><!-- # Faq item-->

              <div class="accordion-item">
                <h3 class="accordion-header">
                  <button
                    class="accordion-button collapsed"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq-content-4"
                  >
                    <span class="num">4.</span>
                    Ac odio tempor orci dapibus. Aliquam eleifend mi in nulla?
                  </button>
                </h3>
                <div
                  id="faq-content-4"
                  class="accordion-collapse collapse"
                  data-bs-parent="#faqlist"
                >
                  <div class="accordion-body">
                    Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id
                    donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque
                    elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.
                  </div>
                </div>
              </div><!-- # Faq item-->

              <div class="accordion-item">
                <h3 class="accordion-header">
                  <button
                    class="accordion-button collapsed"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq-content-5"
                  >
                    <span class="num">5.</span>
                    Tempus quam pellentesque nec nam aliquam sem et tortor consequat?
                  </button>
                </h3>
                <div
                  id="faq-content-5"
                  class="accordion-collapse collapse"
                  data-bs-parent="#faqlist"
                >
                  <div class="accordion-body">
                    Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse in est ante in.
                    Nunc vel risus commodo viverra maecenas accumsan. Sit amet nisl suscipit adipiscing bibendum est.
                    Purus gravida quis blandit turpis cursus in
                  </div>
                </div>
              </div><!-- # Faq item-->

            </div>

          </div>
        </div>
      </div>
    </section><!-- End Frequently Asked Questions Section -->

    <!-- ======= Contact Section ======= -->
    <section
      id="contact"
      class="contact"
    >
      <div
        class="container"
        data-aos="fade-up"
      >
        <div class="section-header">
          <h2>Pengaduan</h2>
          <p>Nulla dolorum nulla nesciunt rerum facere sed ut inventore quam porro nihil id ratione ea sunt quis dolorem
            dolore earum</p>
        </div>

        <div class="row gx-lg-0 gy-4">
          <div class="col-lg-4">
            <div class="info-container d-flex flex-column align-items-center justify-content-center">
              <div class="info-item d-flex">
                <i class="bi bi-geo-alt flex-shrink-0"></i>
                <div>
                  <h4>Lokasi:</h4>
                  <p>Jl. Raya Panglima Sudirman No.02, Sumber Armi, Sumberlele, Kec. Kraksaan, Kabupaten Probolinggo, Jawa
                    Timur <strong>67282</strong></p>
                </div>
              </div><!-- End Info Item -->

              <div class="info-item d-flex">
                <i class="bi bi-envelope flex-shrink-0"></i>
                <div>
                  <h4>Email:</h4>
                  <p>pengaduan@grahasehat.com</p>
                </div>
              </div><!-- End Info Item -->

              <div class="info-item d-flex">
                <i class="bi bi-phone flex-shrink-0"></i>
                <div>
                  <h4>Call:</h4>
                  <p>(0335) 846500</p>
                </div>
              </div><!-- End Info Item -->

              <div class="info-item d-flex">
                <i class="bi bi-clock flex-shrink-0"></i>
                <div>
                  <h4>Jam Buka:</h4>
                  <p>Senin-Sabtu: 08.00 - 15.00</p>
                </div>
              </div><!-- End Info Item -->
            </div>

          </div>

          <div class="col-lg-8">
            <form
              action="forms/contact.php"
              method="post"
              role="form"
              class="php-email-form"
            >
              <div class="row">
                <div class="col-md-6 form-group">
                  <input
                    type="text"
                    name="name"
                    class="form-control"
                    id="name"
                    placeholder="Nama Anda"
                    required
                  >
                </div>
                <div class="col-md-6 form-group mt-3 mt-md-0">
                  <input
                    type="email"
                    class="form-control"
                    name="email"
                    id="email"
                    placeholder="Email Anda"
                    required
                  >
                </div>
              </div>
              <div class="form-group mt-3">
                <input
                  type="text"
                  class="form-control"
                  name="subject"
                  id="subject"
                  placeholder="Judul"
                  required
                >
              </div>
              <div class="form-group mt-3">
                <textarea
                  class="form-control"
                  name="message"
                  rows="7"
                  placeholder="Deskripsi Pengaduan"
                  required
                ></textarea>
              </div>
              <div class="my-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit">Kirim</button></div>
            </form>
          </div><!-- End Contact Form -->

        </div>
      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->
</template>
<script>
import TemukanDokter from "@/views/home/TemukanDokter.vue";
import Berita from "@/views/home/Berita.vue";
import LayananKami from "@/views/home/LayananKami.vue";
import ClientKami from "@/views/home/ClientKami.vue";
import SpesialisKami from "@/views/home/SpesialisKami.vue";

import { Carousel, Navigation, Pagination, Slide } from "vue3-carousel";
import cItem from "@/assets/img/bg-1.jpg";

export default {
  components: {
    Carousel,
    Slide,
    Pagination,
    Navigation,
    SpesialisKami,
    ClientKami,
    LayananKami,
    Berita,
    TemukanDokter,
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