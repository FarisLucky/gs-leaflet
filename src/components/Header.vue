<template>
    <header id="header" class="header d-flex align-items-center">

        <div class="container d-flex align-items-center justify-content-between">
            <router-link :to="{ name: 'Home' }" class="logo d-flex align-items-center">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="assets/img/logo.png" alt=""> -->
                <h1>RSGS<span>.</span></h1>
            </router-link>
            <nav id="navbar" class="navbar">
                <!-- <ul>
                    <li>
                        <router-link :to="{ name: 'Leaflet' }">Leaflet</router-link>
                    </li>
                </ul> -->
            </nav><!-- .navbar -->

            <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
            <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

        </div>
    </header><!-- End Header -->
</template>
<script>
export default {
    name: 'Header'
}
</script>