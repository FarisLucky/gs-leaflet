<template>
  <section class="section-reset">
    <div class="layout-leaflet px-3">
      <div class="mb-1">
        <h4
          class="py-2 border-bottom"
          style="display: inline-block; width: 95%;"
        >Leaflet: </h4>
        <button
          class="btn btn-sm btn-outline-secondary"
          @click="onRefresh"
        >
          <i class="bi bi-arrow-counterclockwise"></i>
        </button>
      </div>
      <div
        v-if="data.leaflets.length < 1"
        class="row"
      >
        <div class="col-md-12 text-end mb-2 bg-reload">
          <button
            class="btn btn-sm btn-outline-secondary"
            @click="onRefresh"
          >
            <i class="bi bi-arrow-counterclockwise"></i>
          </button>
        </div>
        <div class="col-md-12 text-center">
          <easy-spinner />
        </div>
      </div>
      <div
        v-else
        class="row"
      >
        <div
          v-for="(l, idx) in data.leaflets"
          class="col-lg-3 col-md-4 col-6 bg-list"
          :key="idx"
        >
          <div class="card mb-2">
            <div class="card-cs">
              <!-- <img
                v-if="l.m_file.length > 1"
                :src="BASE_URL+'leaflet/view-cover/'+l.id"
                class="card-img-top"
                alt="Card image cap"
              > -->
              <img
                class="card-img-top"
                v-lazy="img"
                alt="Card image cap"
              >
            </div>
            <div class="card-body card-body-cs">
              <div class="card-title">
                <strong>{{ l.judul }}</strong>
              </div>
              <hr class="py-0">
              <div class="card-subtitle">
                <p>{{ l.desc }}</p>
              </div>
              <div class="d-flex justiy-content-between my-1">
                <router-link
                  :to="{ name: 'LeafletDetail', params: { id: l.id, nama: l.judul} }"
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
      <div class="col-md-12 text-center mt-2">
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

export default {
  props: ["leafletsData"],
  data() {
    return {
      img,
      BASE_URL,
      leaflets: [],
    };
  },
  created() {
    this.getLeaflet();
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
          console.log(this.data.leaflets[0].m_file.length);
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
    },

    onRefresh() {
      this.getLeaflet();
    },
  },
};
</script>
<style>
.pagination-container {
  display: flex;
  column-gap: 10px;
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
</style>