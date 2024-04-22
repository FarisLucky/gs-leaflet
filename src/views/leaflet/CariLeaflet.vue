<template>
  <div class="card">
    <div class="card-body my-3 mx-4">
      <form action="">
        <div class="row justify-content-center">
          <div class="col-lg-12">
            <div class="search_dokter_label">
              <strong>Temukan Leaflet yang Tepat</strong>
              <p class="text-center">
                Cari dan temukan leaflet yang tepat untuk kebutuhan anda
              </p>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="mb-2">
              <v-select
                v-model="leaflet"
                :options="leaflets"
                :reduce="(leaflet) => leaflet.id"
                class="cs-vselect"
                placeholder="Ketik untuk Cari E-LEAFLET"
                @search="searchLeaflet"
                @option:selected="onSelected"
              >
                <template v-slot:no-options="{ search, searching }">
                  <template v-if="searching">
                    Tidak ada data <em>{{ search }}</em
                    >.
                  </template>
                  <em v-else style="opacity: 0.5"
                    >Silahkan Ketik untuk cari E-Leaflet</em
                  >
                </template>
              </v-select>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
import { useLeafletStore } from "@/stores/leaflets";
import { mapState, mapActions } from "pinia";
import { leafletService } from "@/services/LeafletService";

export default {
  name: "CariLeaflet",
  data() {
    return {
      leaflets: [],
      leaflet: "",
    };
  },
  computed: {
    ...mapState(useLeafletStore, ["data"]),
  },
  methods: {
    ...mapActions(useLeafletStore, ["setLeaflet", "setSpinner"]),
    onReset() {
      this.leaflets = []
      this.leaflet = "";
    },
    async searchLeaflet(name, loading) {
        console.log(this.data.leaflets)
        if(name.length > 1) {

          loading(true);

          const [err, leaflets] = await leafletService.search(name);

          if (err) {
            alert("LEAFLET GAGAL DIMUAT");
          loading(false);

            return;
          }

          this.data.currentPage = leaflets.data.current_page;
          this.data.ttlItem = leaflets.data.total;
          this.data.itemsPerPage = leaflets.data.per_page;
          this.data.maxPageShow = leaflets.data.per_page;
          this.setLeaflet(leaflets.data.data);
          
          this.leaflets = leaflets.data.data?.map((leaflet)=>{
            return {
              id:leaflet.id,
              label:leaflet.disp_txt,
            }
          })
          loading(false);
        }
    },
    async onSelected2(val) {
      console.log(val)
    },
    async onSearchBlur(val) {
      console.log('--- On Search Blur ----')
      console.log(val)
    },
    async onSelected(val) {
      this.$Progress.start();
      
      const [err, leaflet] = await leafletService.showLeaflet(val.id);

      if (err) {
        alert("LEAFLET GAGAL DIMUAT");
        this.$Progress.fail();

        return;
      }
      
      console.log('---- search ----')
      console.log(this.leaflet)
      console.log(this.leaflets)

      this.data.currentPage = leaflet.data.current_page;
      this.data.ttlItem = leaflet.data.total;
      this.data.itemsPerPage = leaflet.data.per_page;
      this.data.maxPageShow = leaflet.data.per_page;
      this.setLeaflet(leaflet.data.data)

      this.$Progress.fail();
    },
  },
};
</script>