<template>
  <section class="section-reset">
    <div class="container container-cs">
      <div class="layout-leaflet">
        <div class="row">
          <div class="col-md-12 text-end mb-2 bg-reload">
            <button
              class="btn btn-sm btn-outline-secondary"
              @click="onRefresh"
            >
              <i class="bi bi-arrow-counterclockwise"></i>
            </button>
          </div>
          <div
            v-if="data.leaflets.length < 1"
            class="col-md-12 text-center"
          >
            <easy-spinner />
          </div>
          <!-- <TransitionGroup
            name="list"
            tag="ul"
          >
            <li
              v-for="item in items"
              :key="item"
            >
              {{ item }}
            </li>
          </TransitionGroup> -->

          <TransitionGroup
            v-else
            name="list"
            :duration="{ enter: 500, leave: 800 }"
          >
            <div
              v-for="(l, idx) in data.leaflets"
              class="col-md-3 col-6 bg-list"
              :key="idx"
            >
              <div class="card mb-2">
                <img
                  class="card-img-top"
                  :src="img"
                  alt="Card image cap"
                >
                <div class="card-body card-body-cs">
                  <div class="card-title">
                    {{ l.judul }}
                  </div>
                  <div class="card-subtitle">
                    {{ l.desc }}
                  </div>
                  <div class="d-flex justiy-content-between my-1">
                    <router-link
                      :to="{ name: 'LeafletDetail', params: { id: l.id} }"
                      type="button"
                      class="btn btn-primary btn-view"
                    >
                      <i class="bi bi-eye-fill me-1"></i>
                      Lihat
                    </router-link>
                    <button
                      type="button"
                      class="btn btn-outline-dark"
                    >
                      <i class="bi bi-download"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </TransitionGroup>
          <div class="col-md-12 text-center mt-2">
            <vue-awesome-paginate
              :total-items="ttlItem"
              :items-per-page="itemsPerPage"
              :max-pages-shown="maxPageShow"
              v-model="currentPage"
              :on-click="onClickHandler"
            />
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
// import leaflets from "@/files/leaflet-dummy.json";
import img from "@/assets/img/portfolio/app-1.jpg";
import { http } from "@/config/http";
import { useLeafletStore } from "@/stores/leaflets";
import { mapState, mapActions } from "pinia";

export default {
  props: ["leafletsData"],
  data() {
    return {
      img,
      leaflets: [],
      currentPage: 1,
      ttlItem: 1,
      itemsPerPage: 1,
      maxPageShow: 1,
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
    async getLeaflet(page = 1) {
      this.$Progress.start();
      this.setSpinner(true);

      await http
        .get("fr-leaflet/list?page=" + page)
        .then((resp) => {
          this.currentPage = resp.data.data.current_page;
          this.ttlItem = resp.data.data.total;
          this.itemsPerPage = resp.data.data.per_page;
          this.maxPageShow = resp.data.data.per_page;
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
      console.log(page);
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
</style>