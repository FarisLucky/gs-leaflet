<template>
    <section class="section-reset">
        <div class="layout-leaflet px-3">
            <div class="mb-1">
                <h4
                    class="py-2 border-bottom"
                    style="display: inline-block; width: 95%"
                >
                    Leaflet:
                </h4>
                <button
                    class="btn btn-sm btn-outline-secondary"
                    @click="onRefresh"
                >
                    <i class="bi bi-arrow-counterclockwise"></i>
                </button>
            </div>
            <div v-if="data.leaflets.length < 1" class="row">
                <div class="col-md-12 text-center">
                    <div>
                        <img
                            :src="ImgNotFound"
                            alt="Leaflet Tidak ditemukan"
                            style="width: 250px; max-width: 400px"
                        />
                        <h4 class="text-danger mt-2">
                            Leaflet Tidak ditemukan
                        </h4>
                    </div>
                    <easy-spinner v-if="data.loading" />
                </div>
            </div>
            <div v-else class="row">
                <div
                    v-for="(l, idx) in data.leaflets"
                    class="col-lg-3 col-md-4 col-6 bg-list"
                    :key="idx"
                >
                    <div class="card mb-2">
                        <div class="card-cs">
                            <img
                                v-if="l.m_cover !== null"
                                v-lazy="
                                    `${BASE_URL}leaflet/view-cover/${l.id}?order=0`
                                "
                                class="card-img-top"
                                alt="Leaflet Cover"
                            />
                            <img
                                v-else
                                class="card-img-top"
                                v-lazy="img"
                                alt="Leaflet Cover"
                            />
                        </div>
                        <div class="card-body card-body-cs">
                            <div class="card-title">
                                <strong>{{ l.judul }}</strong>
                            </div>
                            <hr class="py-0" />
                            <div class="card-subtitle">
                                <p>{{ l.desc }}</p>
                            </div>
                            <div class="d-flex justiy-content-between my-1">
                                <router-link
                                    :to="{
                                        name: 'LeafletDetail',
                                        params: { id: l.id, nama: l.judul },
                                    }"
                                    type="button"
                                    class="btn btn-primary btn-view"
                                >
                                    <i class="bi bi-eye-fill me-1"></i>
                                    Lihat
                                </router-link>
                                <a
                                    :href="downloadUrl(l.id)"
                                    target="_blank"
                                    class="btn btn-outline-dark"
                                >
                                    <i class="bi bi-download"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <vue-awesome-paginate
                    :total-items="data.ttlItem"
                    :items-per-page="data.itemsPerPage"
                    :max-pages-shown="data.maxPageShow"
                    v-model="data.currentPage"
                    :on-click="onClickHandler"
                />
            </div>
        </div>
    </section>
</template>
<script>
import img from "@/assets/img/init-cvr.png";
import { http } from "@/config/http";
import { useLeafletStore } from "@/stores/leaflets";
import { mapState, mapActions } from "pinia";
import { BASE_URL } from "@/config/http";
import ImgNotFound from "@/assets/not_found.svg";

export default {
    props: ["leafletsData"],
    data() {
        return {
            img,
            BASE_URL,
            leaflets: [],
            ImgNotFound,
        };
    },
    created() {
        this.getLeaflet();
        console.log("list");
    },
    computed: {
        ...mapState(useLeafletStore, ["data"]),
    },
    methods: {
        ...mapActions(useLeafletStore, ["setLeaflet", "setSpinner"]),
        downloadUrl(id) {
            return BASE_URL + "leaflet/download/" + id;
        },
        async getLeaflet(page = 1) {
            console.log("--- GET LEAFLET ----");
            this.$Progress.start();
            this.setSpinner(true);
            this.data.page = page;
            this.data.url = "fr-leaflet/list?page=" + this.data.page;
            await http
                .get(this.data.url)
                .then((resp) => {
                    this.data.currentPage = resp.data.data.current_page;
                    this.data.ttlItem = resp.data.data.total;
                    this.data.itemsPerPage = resp.data.data.per_page;
                    this.data.maxPageShow = resp.data.data.per_page;
                    this.setLeaflet(resp.data.data.data);
                    this.$Progress.finish();
                })
                .catch((err) => {
                    console.log(err);
                    alert("Gagal Loading");
                    this.$Progress.fail();
                })
                .finally(() => {
                    this.setSpinner(false);
                });
        },

        onClickHandler(page) {
            this.getLeaflet(page);
            console.log("--- OnCLick Handler ----");
        },

        onRefresh() {
            console.log("--- OnRefresh Handler ----");
            this.getLeaflet();
        },
    },
};
</script>
<style>
.pagination-container {
    display: flex;
    column-gap: 5px;
}
.paginate-buttons {
    height: 40px;
    width: 40px;
    border-radius: 20px;
    cursor: pointer;
    background-color: rgb(242, 242, 242);
    border: 1px solid rgb(217, 217, 217);
    color: black;
}
.paginate-buttons:hover {
    background-color: #d8d8d8;
}
.active-page {
    background-color: #3498db;
    border: 1px solid #3498db;
    color: white;
}
.active-page:hover {
    background-color: #2988c8;
}
.bg-reload {
    background-color: rgba(146, 146, 146, 0.1);
    border-radius: 4px;
    padding: 0.3rem;
}
.bg-list {
    background-color: rgba(208, 208, 208, 0.1);
    border-radius: 4px;
    padding: 0.3rem;
}
.__S-main__ {
    width: auto;
    height: 9em;
}
.card-cs {
    max-width: 270px;
    max-height: 205px;
    overflow: hidden;
}
.card-cs img {
    max-width: 270px;
    max-height: 205px;
    position: relative;
}
.card-subtitle p {
    font-size: 14px;
    font-weight: 600;
    color: rgb(114, 114, 114);
}

.paginate-buttons {
    width: 40px;
    height: 40px;
    cursor: pointer;
    background-color: #e6e6e6;
    border: none;
}

.back-button,
.next-button {
    margin-inline: 10px;
    border-radius: 25px;
}

.first-button {
    border-start-start-radius: 25px;
    border-end-start-radius: 25px;
}
.last-button {
    border-start-end-radius: 25px;
    border-end-end-radius: 25px;
}

.back-button svg {
    transform: rotate(180deg) translateY(-2px);
}
.next-button svg {
    transform: translateY(2px);
}

/* select second element of .paginate-buttons */
li:nth-child(2) > .paginate-buttons.number-buttons {
    border-start-start-radius: 25px;
    border-end-start-radius: 25px;
    transition: none;
}

/* select one element before last of .paginate-buttons */
li:nth-last-child(2) > .paginate-buttons.number-buttons {
    border-start-end-radius: 25px;
    border-end-end-radius: 25px;
}

.active-page {
    background-color: #2980b9;
    color: #fff;
}

.active-page {
    background-color: #2980b9;
    color: #fff;
}

.paginate-buttons:hover {
    background-color: #f5f5f5;
}

.active-page:hover {
    background-color: #388ac1;
}
.back-button:active,
.next-button:active {
    background-color: #e6e6e6;
}
</style>