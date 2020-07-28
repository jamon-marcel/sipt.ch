<template>
<div class="select-wrapper is-sm is-light">
  <select v-model="current" @change="change($event.target.value)">
    <option value="/administration/backoffice/modules">Module</option>
    <option value="/administration/backoffice/invoices">Rechnungen</option>
    <option value="/administration/backoffice/import">Import</option>
  </select>
</div>
</template>
<script>
export default {

  data() {
    return {
      current: this.$router.currentRoute.path,
    }
  },
  methods: {
    change(target) {
      this.$router.push(target) 
    },
  }
}
</script>
