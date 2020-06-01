<template>
<div>
  <notifications classes="notification" />
  <page-header />
  <main class="site">
    <router-view></router-view>
  </main>
</div>
</template>
<script>
import PageHeader from '@/administration/layout/PageHeader.vue';
export default {
  components: {
    PageHeader
  },
}
</script>