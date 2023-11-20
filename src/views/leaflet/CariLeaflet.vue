<template>
  <div class="card">
    <div class="card-body my-3 mx-4">
      <form action="">
        <div class="row">
          <div class="col-lg-12">
            <div class="search_dokter_label">
              <strong>Temukan Leaflet yang Tepat</strong>
              <p>
                Cari dan temukan leaflet yang tepat untuk kebutuhan anda
              </p>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="mb-2">
              <v-select
                v-model="leaflet"
                :options="leaflets"
                label="disp_txt"
                :reduce="leaflet => leaflet.id"
                class="cs-vselect"
                placeholder="Cari Leaflet"
                @search="search"
                @option:selected="onSelected"
              >
                <!-- <template slot="singleLabel" slot-scope="{ option }"
                                 -->
              </v-select>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="mb-2">
              <v-select
                v-model="unit"
                :options="units"
                label="unit"
                placeholder="Unit"
                class="cs-vselect"
                :reduce="unit => unit.unit"
                @option:selected="onSelectedUnit"
              >
              </v-select>
            </div>
          </div>
          <div class="col-lg-2">
            <div class="mb-2">
              <button
                type="button"
                class="btn w-100 btn-search-dokter bg-secondary"
                @click="onReset"
              >
                Reset
                <!-- <i class="bi bi-search"></i> -->
                <i class="bi bi-arrow-counterclockwise"></i>
              </button>
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

export default {
  name: "CariLeaflet",
  data() {
    return {
      leaflets: [],
      leaflet: "",
      units: [],
      unit: "",
    };
  },
  created() {
    this.getUnits();
  },
  methods: {
    ...mapActions(useLeafletStore, ["setLeaflet", "setSpinner"]),
    onReset() {
      this.unit = "";
      this.leaflet = "";
    },
    async search(name, loading) {
      if (name.length > 3) {
        this.$Progress.start();
        await http
          .get(`fr-leaflet/search/${name}`)
          .then((resp) => {
            this.leaflets = resp.data.data;
            this.$Progress.finish();
          })
          .catch((err) => {
            console.log(err);
            alert("Gagal Loading");
            this.$Progress.fail();
          });
      }
    },
    async getUnits() {
      this.$Progress.start();
      await http
        .get(`fr-leaflet/units`)
        .then((resp) => {
          this.units = resp.data.data;
          console.log(this.units);
          this.$Progress.finish();
        })
        .catch((err) => {
          console.log(err);
          alert("Gagal Loading");
          this.$Progress.fail();
        });
    },
    async onSelected(val) {
      this.$Progress.start();
      this.setSpinner(true);
      await http
        .get(`fr-leaflet/show-leaflet/${val.id}`)
        .then((resp) => {
          this.setLeaflet(resp.data.data);
          this.$Progress.finish();
        })
        .catch((err) => {
          alert("Gagal Loading");
          this.$Progress.fail();
        })
        .finally(() => {
          this.setSpinner(false);
        });
    },
    async onSelectedUnit(val) {
      this.$Progress.start();
      console.log(val.unit);
      this.setSpinner(true);
      await http
        .get(`fr-leaflet/show-leaflet-by-unit/${val.unit}`)
        .then((resp) => {
          this.setLeaflet(resp.data.data);
          this.$Progress.finish();
        })
        .catch((err) => {
          alert("Gagal Loading");
          this.$Progress.fail();
        })
        .finally(() => {
          this.setSpinner(false);
        });
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