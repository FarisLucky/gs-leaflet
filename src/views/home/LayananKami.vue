<template>
    <div>
        <div class="cs-header">
            <div class="container" data-aos="fade-up">
                <h2>Layanan Kami</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat, laborum. Repudiandae consequatur
                    voluptatem.</p>
            </div>
        </div>
        <div class="container" data-aos="fade-up">
            <div class="row gy-4 layanan-card-layout" data-aos="fade-up" data-aos-delay="100">
                <div class="col-6 col-lg-3 col-md-6" v-for="idx in 8">
                    <div class="service-item position-relative card-layanan">
                        <div class="icon">
                            <img :src="DentalIcon" alt="">
                        </div>
                        <h3>layanan</h3>
                        <p>Layanan Operasi Katarak menggunakan teknik <strong>PHAECO EMULSIFIKASI</strong></p>
                        <a href="#" class="readmore stretched-link">Detail <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div><!-- End Service Item -->
            </div>
        </div>
    </div>
</template>
<script>
import DentalIcon from "@/assets/img/icons/icons8-dental-checkup-50.png"
export default {
    name: "LayananKami",
    data() {
        return {
            DentalIcon
        }
    }
}
</script>