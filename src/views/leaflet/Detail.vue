<template>
  <section class="section-reset">
    <div class="container container-cs">
      <div class="layout-leaflet">
        <div class="row">
          <div class="col-md-12 text-start mb-2">
            <div class="d-flex justify-content-between">
              <div>
                <a
                  href="javascript(0)"
                  class="btn btn-secondary"
                  @click.prevent="() => $router.back()"
                >
                  <i class="bi bi-arrow-left-circle"></i>
                  Kembali
                </a>
              </div>
              <h3 class="d-inline-block">
                <strong>{{ $route.params.nama }}</strong>
              </h3>
              <div></div>
            </div>
          </div>
          <div class="col-md-12">
            <div
              class="mb-1"
              v-if="pdfSource !== null"
            >
              <vue-pdf-app
                theme="light"
                style="height: 100vh;"
                :pdf="pdfSource"
              ></vue-pdf-app>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import VuePdfApp from "vue3-pdf-app";
import "vue3-pdf-app/dist/icons/main.css";
import { leafletService } from "@/services/LeafletService";

export default {
  components: { VuePdfApp },
  data() {
    return {
      pdfSource: null,
    };
  },
  created() {
    this.getPdf(this.$route.params.id);
  },
  methods: {
    async getPdf(id) {
      const [err, leaflet] = await leafletService.pdf(id);

      if (err) {
        console.log(err);
        alert(err);
      }

      const blob = new Blob([leaflet]);
      const objectUrl = URL.createObjectURL(blob);
      this.pdfSource = objectUrl;
    },
  },
  beforeUnmount() {
    URL.revokeObjectURL(this.pdfSource);
  },
};
</script>