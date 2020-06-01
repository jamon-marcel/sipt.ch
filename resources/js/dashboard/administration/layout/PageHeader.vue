<template>
<div>
  <header class="page-header">
    <div>
      <a href="/" class="brand">
       <logo />
      </a>
      <a href="javascript:;" @click="toggleMenu()" class="icon-menu"></a>
    </div>
  </header>
  <nav :class="[!menuVisible ? '' : 'is-visible', 'page']">
    <div>
      <a href="javascript:;" @click="toggleMenu()" class="icon-close"></a>
    </div>
    <ul>
      <li>
        <router-link :to="{name: 'trainings'}">Fortbildungen</router-link>
      </li>
    </ul>
    <a href="/logout" class="icon-logout">Logout</a>
  </nav>
</div>
</template>
<script>
import Logo from '@/global/components/theme/Logo.vue';
export default {
  components: {
    Logo,
  },
	data() {
		return {
			menuVisible: false
		}
	},
	methods: {
		toggleMenu() {
			this.menuVisible = this.menuVisible ? false : true;
		}
  },
  watch: {
    '$route'() {
      this.menuVisible = false
    }
  }
}
</script>
