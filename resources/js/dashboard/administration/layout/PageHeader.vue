<template>
<div>
  <header class="page-header">
    <div>
      <a href="/administration" class="brand">
       <logo />
      </a>
      <a href="javascript:;" @click="toggleMenu()" class="feather-icon">
        <menu-icon size="24"></menu-icon>
      </a>
    </div>
  </header>
  <nav :class="[!menuVisible ? '' : 'is-visible', 'page']">
    <header>
      <span>
        {{user}}<br>
        <a href="/logout" class="feather-icon feather-icon--prepend">
          <log-out-icon size="12"></log-out-icon>
          <span>Logout</span>
        </a>
      </span>
      <a href="javascript:;" @click="toggleMenu()" class="feather-icon ">
        <arrow-right-icon size="24"></arrow-right-icon>
      </a>
    </header>
    <ul>
      <li>
        <a href="javascript:;" @click="toggleSeiteninhalte()" class="nav-parent">
          <span>Seiteninhalte</span>
          <chevron-down-icon size="24" :class="[contentVisible ? 'is-rotated' : '']"></chevron-down-icon>
        </a>
        <ul v-show="contentVisible" class="nav-children">
          <li>
            <router-link :to="{name: 'news-articles'}">
              <span>Aktuelles</span>
            </router-link>
          </li>
          <li>
            <router-link :to="{name: 'resilience-tips'}">
              <span>Aufbau-Tipps</span>
            </router-link>
          </li>
          <li>
            <router-link :to="{name: 'downloads'}">
              <span>Downloads</span>
            </router-link>
          </li>
          <li>
            <router-link :to="{name: 'partners'}">
              <span>Partner-Institutionen</span>
            </router-link>
          </li>
          <li>
            <router-link :to="{name: 'locations'}">
              <span>Veranstaltungsorte</span>
            </router-link>
          </li>
          <li>
            <router-link :to="{name: 'therapists'}">
              <span>Psychotherapeuten</span>
            </router-link>
          </li>
        </ul>
      </li>
      <li>
        <router-link :to="{name: 'trainings'}">
          <span>Fortbildungen</span>
        </router-link>
      </li>
      <li>
        <router-link :to="{name: 'courses'}">
          <span>Module</span>
        </router-link>
      </li>
      <li>
        <router-link :to="{name: 'tutors'}">
          <span>Dozenten</span>
        </router-link>
      </li>
      <li>
        <router-link :to="{name: 'students'}">
          <span>Studenten</span>
        </router-link>
      </li>
      <li>
        <router-link :to="{name: 'mailings'}">
          <span>Mailings</span>
        </router-link>
      </li>
      <li>
        <router-link :to="{name: 'backoffice-invoices'}">
          <span>Buchhaltung</span>
        </router-link>
      </li>
      <li>
        <router-link :to="{name: 'vip-addresses'}">
          <span>VIP Adressen</span>
        </router-link>
      </li>
    </ul>
  </nav>
</div>
</template>
<script>

// Icons
import { ArrowRightIcon, MenuIcon, LogOutIcon, ChevronDownIcon } from 'vue-feather-icons';

// Theme
import Logo from '@/global/components/theme/Logo.vue';

export default {
  components: {
    Logo,
    ArrowRightIcon,
    MenuIcon,
    LogOutIcon,
    ChevronDownIcon,
  },

  props: {
    user: '',
  },

	data() {
		return {
			menuVisible: false,
			contentVisible: false
		}
  },

	methods: {
		toggleMenu() {
			this.menuVisible = this.menuVisible ? false : true;
		},
		toggleSeiteninhalte() {
			this.contentVisible = !this.contentVisible;
		}
  },

  watch: {
    '$route'() {
      this.menuVisible = false
    }
  }
}
</script>

<style scoped>
.nav-parent {
  display: flex;
  align-items: center;
  justify-content: space-between;
  cursor: pointer;
  padding-right: 20px;
}

.nav-parent svg {
  transition: transform 0.2s ease;
}

.nav-parent svg.is-rotated {
  transform: rotate(180deg);
}

.nav-children {
  border-top: none !important;
  list-style: none;
  margin-left: 0;
}

.nav-children li {
  margin: 0;
}

/* Override dashboard nav styles to match parent item height */
.nav-children ::v-deep a {
  padding-left: 30px !important;
  padding-top: 15px !important;
  padding-bottom: 15px !important;
}
</style>
