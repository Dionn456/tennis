<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container">
      <router-link :to="{ name: user ? 'home' : 'welcome' }" class="navbar-brand">
        Tennishallen Hengelo
      </router-link>

      <div id="navbar" class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <!-- Authenticated -->
          <li v-if="user && user.role_id == 3" class="nav-item mr-5">
            <router-link :to="{ name: 'invoices' }" class="nav-link" active-class="active">
              Facturen
            </router-link>
          </li>
          <li v-if="user && user.role_id !== 4" class="nav-item mr-5">
            <router-link :to="{ name: 'appointments' }" class="nav-link" active-class="active">
              Tennis
            </router-link>
          </li>
          <li v-if="user && user.role_id == 1" class="nav-item mr-5">
            <router-link :to="{ name: 'courts' }" class="nav-link" active-class="active">
              Banen
            </router-link>
          </li>
          <li v-if="user && user.role_id == 1" class="nav-item mr-5">
            <router-link :to="{ name: 'users' }" class="nav-link" active-class="active">
              Gebruikers
            </router-link>
          </li>
          <li v-if="user" class="nav-item dropdown mx-3">
            <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              <img :src="user.photo_url" class="rounded-circle profile-photo me-1">
              {{ user.name }}
            </a>
            <div class="dropdown-menu">
              <router-link :to="{ name: 'settings.profile' }" class="dropdown-item ps-3">
                <fa icon="cog" fixed-width />
                {{ $t('settings') }}
              </router-link>

              <div class="dropdown-divider" />
              <a href="#" class="dropdown-item ps-3" @click.prevent="logout">
                <fa icon="sign-out-alt" fixed-width />
                {{ $t('logout') }}
              </a>
            </div>
          </li>
          <!-- Guest -->
          <template v-else>
            <li class="nav-item">
              <router-link :to="{ name: 'login' }" class="nav-link" active-class="active">
                {{ $t('login') }}
              </router-link>
            </li>
            <li class="nav-item">
              <router-link :to="{ name: 'register' }" class="nav-link" active-class="active">
                {{ $t('register') }}
              </router-link>
            </li>
          </template>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import { mapGetters } from 'vuex'
import LocaleDropdown from './LocaleDropdown'

export default {
  components: {
    LocaleDropdown
  },

  data: () => ({
    appName: window.config.appName
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    async logout() {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
    }
  }
}
</script>

<style scoped>
.profile-photo {
  width: 2rem;
  height: 2rem;
  margin: -.375rem 0;
}

.container {
  max-width: 1100px;
}
</style>
