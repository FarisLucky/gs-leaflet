<template>
  <header
    id="header"
    class="header d-flex align-items-center"
  >

    <div class="container d-flex align-items-center justify-content-between">
      <router-link
        :to="{ name: 'Home' }"
        class="logo d-flex align-items-center"
      >
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1>E-LEAFLET<span>.</span></h1>
      </router-link>
      <nav
        id="navbar"
        class="navbar"
        :class="{'right-show': rightVal}"
      >
        <i
          class="mobile-nav-toggle mobile-nav-hide bi bi-x"
          @click="()=> rightVal = false"
        ></i>
        <ul>
          <li>
            <a
              href="javascript(0)"
              @click.prevent="windowReload"
            >Refresh</a>
          </li>
        </ul>
      </nav><!-- .navbar -->

      <i
        class="mobile-nav-toggle mobile-nav-show bi bi-list"
        :class="{'d-none': rightVal}"
        @click="()=> rightVal = true"
      ></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

    </div>
  </header><!-- End Header -->
</template>
<script>
export default {
  name: "Header",
  data() {
    return {
      rightVal: false,
    };
  },
  methods: {
    windowReload() {
      location.reload(true);
    },
  },
};
</script>
<style>
.right-show {
  right: 0% !important;
}
</style>