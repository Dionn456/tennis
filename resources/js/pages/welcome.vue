<template>
  <div>
    <div class="text-center"> <!-- content-->
     <!--  -->
      
      <div id="myCarousel" class="carousel slide" data-bs-ride="carousel" >
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="/img/tennishallen.webp" class="d-block w-100" alt="Wild Landscape"/>
            <div class="container">
              <div class="carousel-caption text-start">
                <h1>Baan huren?</h1>
                <p>Registreer u hieronder om een les te boeken.</p>
                <router-link :to="{ name: 'register' }" class="btn btn-lg btn-primary" active-class="active">
                  Registreren
                </router-link>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img src="/img/les.jpg" class="d-block w-100" alt="Wild Landscape"/>

            <div class="container">
              <div class="carousel-caption text-end">
                <h1>Another example headline.</h1>
                <p>Some representative placeholder content for the second slide of the carousel.</p>
                <router-link :to="{ name: 'register' }" class="btn btn-lg btn-primary" active-class="active">
                  Registreren
                </router-link>
              </div>
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>

     <!-- -->
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  layout: 'basic',

  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: window.config.appName
  }),

  computed: mapGetters({
    authenticated: 'auth/check'
  })
}
</script>

<style scoped>
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}

.title {
  font-size: 85px;
}

.carousel .carousel-item {
  height: 500px;
}

.carousel-item img {
    position: absolute;
    object-fit:cover;
    top: 0;
    left: 0;
    min-height: 500px;
}

</style>
