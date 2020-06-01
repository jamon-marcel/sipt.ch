<template>
<div>
  <error-messages />
  <notifications classes="notification" />
  <router-view></router-view>
</div>
</template>
<script>
import ErrorMessages from '@/global/components/ui/ErrorMessages.vue';
export default {
  components: {
    ErrorMessages,
  },
}
</script>