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
                <h1>Beter worden in tennis?</h1>
                <p>Log dan in om een les aan te vragen.</p>
                <router-link :to="{ name: 'login' }" class="btn btn-lg btn-primary" active-class="active">
                  Login
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
      <div class="container">
        <div class="p-3 pb-md-4 mx-auto text-start">
          <div class="row">
            <div class="col-md-6">
              <h1 class="display-4 fw-normal ">Over ons</h1>

              <p class="fs-5 text-muted">
                Tennishallen Hengelo is een initiatief van Richard van Dongen. Zijn specialiteit ligt in het verhuren van tennisbanen, 
                waarbij we sportliefhebbers de kans bieden om per uur een baan te reserveren. Ons unieke aanbod: elke tennisbaan is 
                vernoemd naar een beroemde tennislegende. Zo geniet je niet alleen van onze topfaciliteiten, maar duik je ook in de 
                rijke historie van de tennissport.</p>
                <p>Phone: <a href="callto:074 242 2424">074 242 2424</a></p>
                <p>Email: <a href="mailto:info@tennisbaanhengelo.nl">info@tennisbaanhengelo.nl</a></p>
                <p>Locatie: <a href="https://maps.google.com/maps?hl=nl&gl=nl&um=1&ie=UTF-8&fb=1&sa=X&ftid=0x47b81196f4533155:0xa8a9026e7f07596e">Veldwijk, Kuipersdijk 32, 7552 BJ Hengelo</a></p>

            </div>
            <div class="col-md-6">
              <h1 class="display-4 fw-normal">Openingstijden</h1>
                <p>Maandag: <span class="text-muted">9:00-23:00</span> uur</p>
                <p>Dinsdag: <span class="text-muted">9:00-23:00</span> uur</p>
                <p>Woensdag: <span class="text-muted">9:00-23:00</span> uur</p>
                <p>Donderdag: <span class="text-muted">9:00-23:00</span> uur</p>
                <p>Vrijdag: <span class="text-muted">9:00-23:00</span> uur</p>
                <p>Zaterdag: <span class="text-muted">9:00-23:00</span> uur</p>
                <p>Zondag: <span class="text-muted">9:00-23:00</span> uur</p>
              
            </div>
          </div>
        </div>

        <div class="p-3 pb-md-4 mx-auto text-center">
          <h1 class="display-4 fw-normal">Tennis docenten</h1>
        </div>
        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
        <div class="col">
          <div class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3">
              <h4 class="my-0 fw-normal">Thijmen Meeuwis</h4>
            </div>
            <div class="card-body">
              <img src="/img/Thijmen_meeuwis.png" class="d-block w-100" alt="Wild Landscape"/>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3">
              <h4 class="my-0 fw-normal">Mootje teniso</h4>
            </div>
            <div class="card-body">
              <img src="/img/Mootje_teniso.png" class="d-block w-100" alt="Wild Landscape"/>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3">
              <h4 class="my-0 fw-normal">Serena Slagmisser</h4>
            </div>
            <div class="card-body">
              <img src="/img/Serena_slagmisser.png" class="d-block w-100" alt="Wild Landscape"/>
            </div>
          </div>
        </div>
      </div>
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
