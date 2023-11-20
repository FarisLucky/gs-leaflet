<template>
    <div class="cs-header">
        <h2>Berita Terbaru</h2>
        <p>Rumah Sakit Graha Sehat</p>
    </div>

    <div class="cs-body">
        <div class="row gy-4">
            <div class="col-6 col-md-3" v-for="idx in 6">
                <div class="card card-berita">
                    <div class="card-body">
                        <img :src="Bg" alt="" class="card-img">
                        <div class="d-flex flex-column card-desc">
                            <span class="card-tgl">20 Januari 2022</span>
                            <span class="card-title">Layanan Jantung Anak</span>
                            <span class="card-subtitle">Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis
                                quaerat enim aliquam eum vel sint atque repudiandae odit? Provident dolor voluptatem
                                voluptatibus
                                explicabo fugit. Odio iure beatae dolores unde tempora!</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Bg from "@/assets/img/bg-1.jpg"
export default {
    name: "Berita",
    data() {
        return {
            Bg
        }
    }
}
</script>