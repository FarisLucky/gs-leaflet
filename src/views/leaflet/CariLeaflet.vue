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
                label="disp_txt"
                :reduce="(leaflet) => leaflet.id"
                class="cs-vselect"
                placeholder="Ketik untuk Cari E-LEAFLET"
                @search="search"
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
import { http } from "@/config/http";
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
  watch: {
    unit(newVal) {
      if (newVal != "") {
        this.leaflet = "";
      }
    },
    leaflet(newVal) {
      if (newVal != "") {
        this.unit = "";
      }
    },
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
    async search(name, loading) {
        this.leaflets = []
        
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
        
        leaflets.data.data?.forEach((leaflet)=>{
          this.leaflets.push({
            id:leaflet.id,
            disp_txt:leaflet.disp_txt,
          })
        })
        
        loading(false);
    },
    async onSelected(val) {
      this.$Progress.start();
      this.data.url = `fr-leaflet/show-leaflet/${val.id}`;
      await http
        .get(this.data.url)
        .then((resp) => {
          console.log(resp.data.data)
          this.data.currentPage = resp.data.data.current_page;
          this.data.ttlItem = resp.data.data.total;
          this.data.itemsPerPage = resp.data.data.per_page;
          this.data.maxPageShow = resp.data.data.per_page;
          this.data.leaflets = resp.data.data.data
          console.log(val)
          console.log(this.data.leaflets)
          this.$Progress.finish();
        })
        .catch((err) => {
          alert("Gagal Loading");
          this.$Progress.fail();
        })
    },
    asyncFind(query) {
      this.isLoading = true;
      ajaxFindCountry(query).then((response) => {
        this.countries = response;
        this.isLoading = false;
      });
    },
    clearAll() {
      this.selectedCountries = [];
    },
  },
};
</script>