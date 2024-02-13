<template>
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
          <strong>Judul</strong>
        </h3>
        <div></div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="bg-flip">
        <fullscreen
          v-model="fullscreen"
          :teleport="teleport"
          :page-only="pageOnly"
        >
          <div class="fullscreen-wrapper">
            <div class="mb-1">
              <button
                type="button"
                class="btn btn-sm btn-outline btn-light"
                @click="fullscreenToggle"
              >
                <i
                  v-if="fullscreen"
                  class="bi bi-x-circle"
                ></i>
                <i
                  v-else
                  class="bi bi-arrows-fullscreen"
                ></i>
              </button>
            </div>
            <flipbook
              class="flipbook"
              :pages="pages"
              :pagesHiRes="pagesHiRes"
              :clickToZoom="false"
              :singlePage="false"
              :startPage="pageNum"
              v-slot="flipbook"
              ref="flipbook"
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
        </fullscreen>
      </div>
    </div>
  </div>
</template>
<script>
import Flipbook from "flipbook-vue";
import { http } from "@/config/http";

export default {
  components: { Flipbook },
  data() {
    return {
      pages: [],
      pagesHiRes: [],
      hasMouse: true,
      pageNum: null,
      details: [],
      fullscreen: false,
      teleport: true,
      pageOnly: true,
    };
  },
  created() {
    this.loadLeaflet(this.$route.params.id);
    this.onLoad();
  },
  methods: {
    async loadLeaflet(id) {
      await http
        .get(`fr-leaflet/show/${id}`)
        .then((resp) => {
          resp.data.data.forEach((item) => {
            this.details.push(item.urlFile);
          });
        })
        .catch((err) => {
          console.log(err);
          alert("Gagal Loading");
        });
    },
    onLoad() {
      this.pages = this.details;
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
    fullscreenToggle() {
      this.fullscreen = !this.fullscreen;
    },
  },

  mounted() {
    console.log("URL", window.location.href);
    window.addEventListener("hashchange", this.setPageFromHash);
    this.setPageFromHash();
  },
};
</script>

<style>
.flipbook {
  width: 100%;
  height: 90vh;
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

/* .bg-flip {
  background-color: rgb(33, 37, 41);
} */

.page {
  background-color: #ffffff;
}

.page-num {
  color: #ffffff;
}
.fullscreen-wrapper {
  width: 100%;
  height: 100%;
  background: #333;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 20px;
  /* z-index: 9999; */
}
.fullscreen {
  z-index: 9999;
  left: 50%;
  /* overflow: hidden; */
}
.fullscreen-wrapper .button {
  margin-bottom: 20px;
}

@media (min-width: 1400px) {
  .fullscreen .flipbook-container {
    left: 18% !important;
  }
}
</style>