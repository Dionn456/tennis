<template>
  <div>
    <div class="top-right links">
      <template v-if="authenticated">
        <router-link :to="{ name: 'home' }">
          {{ $t('home') }}
        </router-link>
      </template>
      <template v-else>
        <router-link :to="{ name: 'login' }">
          {{ $t('login') }}
        </router-link>
        <router-link :to="{ name: 'register' }">
          {{ $t('register') }}
        </router-link>
      </template>
    </div>

    <div class="text-center">
      <div class="title mb-4">
        {{ title }}
      </div>
      <card title="card"  class="w-100">
        test
      </card>
      <div class="container mt-4">
        <div class="row">
          <div class="col">
            <h1>Welkom bij Tennishallen Hengelo</h1>
            <p>Registreer nu om toegang te krijgen tot onze tennisfaciliteiten. Al geregistreerd? Log dan in om te beginnen met spelen!</p>
            <div class="row">
              <div class="col-md-6">
                <h2>Registreren</h2>
                <!-- Registratieformulier hier toevoegen -->
                <p>Vul het registratieformulier in om lid te worden.</p>
                <a href="#" class="btn btn-primary">Registreren</a>
              </div>
              <div class="col-md-6">
                <h2>Inloggen</h2>
                <!-- Inlogformulier hier toevoegen -->
                <p>Heb je al een account? Log dan hier in.</p>
                <a href="#" class="btn btn-primary">Inloggen</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      
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
</style>
