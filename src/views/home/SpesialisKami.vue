<template>
    <div>
        <div class="cs-header">
            <h3>Spesialis Kami</h3>
            <p>
                Rumah sakit memiliki dokter spesialis
            </p>
        </div>
        <div class="row gy-4" data-aos="fade-up" data-aos-delay="100">
            <div class="col-lg-3 col-md-6" v-for="idx in 8">
                <div class="position-relative card-spesialis">
                    <div class="card-body">
                        <div class="icon">
                            <!-- <img src="https://img.icons8.com/external-icongeek26-outline-icongeek26/64/000000/external-baby-pregnancy-amp-maternity-icongeek26-outline-icongeek26-1.png" class="img-icon" /> -->
                            <img :src="iconsBaby" alt="" class="img-icon">
                        </div>
                        <h3>Spesialis <span class="text-primary">Anak</span></h3>
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        </p>
                    </div>
                </div>
            </div><!-- End Service Item -->
        </div>
    </div>
</template>
<script>
import iconsBaby from "@/assets/img/icons/icons8-baby-64.png"

export default {
    name: 'SpesialisKami',
    data() {
        return {
            iconsBaby
        }
    }
}
</script>