<template>
  <section class="section-reset">
    <div class="container-fluid container-cs">
      <div class="layout-leaflet">
        <div class="row">
          <div class="col-md-12 text-start mb-2">
            <div class="d-flex justify-content-between">
              <div>
                <a
                  href="javascript(0)"
                  class="btn btn-secondary text-white"
                  @click.prevent="() => $router.back()"
                >
                  <i class="bi bi-arrow-left-circle"></i>
                  Kembali
                </a>
              </div>
              <h3 class="d-inline-block">
                <strong>{{ $route.params.nama }}</strong>
              </h3>
              <div>
                <a
                  :href="downloadUrl($route.params.id)"
                  target="_blank"
                  class="btn btn-outline-dark"
                  data-toggle="tooltip"
                  data-placement="top"
                  title="Download Leaflet ?"
                >
                  <i class="bi bi-download"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="bg-flip">
              <flipbook
                class="flipbook"
                :pages="pages"
                :pagesHiRes="pagesHiRes"
                :clickToZoom="false"
                :singlePage="true"
                :startPage="pageNum"
                v-slot="flipbook"
                ref="flipbook"
                @flip-left-start="onFlipLeftStart"
                @flip-left-end="onFlipLeftEnd"
                @flip-right-start="onFlipRightStart"
                @flip-right-end="onFlipRightEnd"
                @zoom-start="onZoomStart"
                @zoom-end="onZoomEnd"
              >

                <div class="action-bar">
                  <a
                    href="#"
                    class="btn-flip left"
                    :class="{ disabled: !flipbook.canFlipLeft }"
                    @click.prevent="flipbook.flipLeft"
                  >
                    <i class="bi bi-arrow-left-circle"></i>
                  </a>
                  <a
                    href="javascript(0)"
                    class="btn-flip"
                    :class="{ disabled: !flipbook.canZoomIn }"
                    @click.prevent="flipbook.zoomIn"
                  >
                    <i class="bi bi-zoom-in"></i>
                  </a>
                  <span class="page-num">
                    Page {{ flipbook.page }} of {{ flipbook.numPages }}
                  </span>
                  <a
                    href="javascript(0)"
                    class="btn-flip"
                    :class="{ disabled: !flipbook.canZoomOut }"
                    @click.prevent="flipbook.zoomOut"
                  >
                    <i class="bi bi-zoom-out"></i>
                  </a>
                  <a
                    href="javascript(0)"
                    class="btn-flip right"
                    :class="{ disabled: !flipbook.canFlipRight }"
                    @click.prevent="flipbook.flipRight"
                  >
                    <i class="bi bi-arrow-right-circle"></i>
                  </a>
                </div>
              </flipbook>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import Flipbook from "flipbook-vue";
import "vue3-pdf-app/dist/icons/main.css";
import { leafletService } from "@/services/LeafletService";
import { directive as fullscreen } from "vue-fullscreen";
import { BASE_URL } from "@/config/http";

export default {
  components: { Flipbook, fullscreen },
  data() {
    return {
      pdfSource: null,
      pages: [],
      pagesHiRes: [],
      hasMouse: true,
      pageNum: null,
      details: [],
      fullscreen: false,
      teleport: false,
      pageOnly: true,
      target: ".fullscreen-wrapper",
    };
  },
  created() {
    this.loadLeaflet(this.$route.params.id);
  },
  directive: {
    fullscreen,
  },
  methods: {
    downloadUrl(id) {
      return BASE_URL + "leaflet/download/" + id;
    },
    async loadLeaflet(id) {
      const [err, leaflets] = await leafletService.detailImage(id);

      if (err) {
        alert("LEAFLET GAGAL DIMUAT");
        this.$router.back();
        return;
      }

      this.pages = leaflets;
    },
    onFlipLeftStart(page) {
      console.log("flip-left-start", page);
    },
    onFlipLeftEnd(page) {
      console.log("flip-left-end", page);
      // window.location.hash = '#' + page
    },
    onFlipRightStart(page) {
      console.log("flip-right-start", page);
    },
    onFlipRightEnd(page) {
      console.log("flip-right-end", page);
      // window.location.hash = '#' + page
    },
    onZoomStart(zoom) {
      console.log("zoom-start", zoom);
    },
    flipLeft() {},
    onZoomEnd(zoom) {
      console.log("zoom-end", zoom);
    },
    setPageFromHash() {
      const n = parseInt(window.location.href.slice(1), 10);
      if (isFinite(n)) this.pageNum = n;
    },
    toggle() {
      this.fullscreen = !this.fullscreen;
    },
  },
  mounted() {
    console.log("URL", window.location.href);
    window.addEventListener("hashchange", this.setPageFromHash);
    this.setPageFromHash();
  },
  beforeUnmount() {
    URL.revokeObjectURL(this.pdfSource);
  },
};
</script>

<style scoped>
.flipbook {
  width: auto;
  height: 100vh;
  overflow: hidden;
  text-overflow: ellipsis;
}

a {
  color: inherit;
}

.action-bar {
  width: 100%;
  height: 30px;
  padding: 20px 0 30px 0;
  display: flex;
  justify-content: center;
  align-items: center;
}

.action-bar .btn-flip {
  font-size: 30px;
  color: #999;
}

.action-bar .btn-flip svg {
  bottom: 0;
}

.action-bar .btn-flip:not(:first-child) {
  margin-left: 10px;
}

.has-mouse .action-bar .btn-flip:hover {
  color: #ccc;
  filter: drop-shadow(1px 1px 5px #000);
  cursor: pointer;
}

.action-bar .btn-flip:active {
  filter: none !important;
}

.action-bar .btn.disabled {
  color: #666;
  pointer-events: none;
}

.action-bar .page-num {
  font-size: 12px;
  margin-left: 10px;
}

.flipbook .bounding-box {
  box-shadow: 0 0 20px #000;
}

.bg-flip {
  background-color: rgb(33, 37, 41);
  padding: 1rem;
  margin-bottom: 1rem;
}

.page {
  background-color: #ffffff;
}

.page-num {
  color: #ffffff;
}

/**
  fullscreen
*/

.fullscreen-wrapper {
  width: 100%;
  height: 100%;
  background: #333;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 5px;
  z-index: 9999;
}
.fullscreen-wrapper .button {
  margin-bottom: 60px;
}
</style>  