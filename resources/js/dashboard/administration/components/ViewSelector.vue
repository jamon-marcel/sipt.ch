<template>
  <div class="select-wrapper is-light">
    <select v-model="current" @change="change($event.target.value)">
      <option v-for="(item, index) in items" :key="index" :value="item.route">{{ item.label }}</option>
    </select>
  </div>
</template>
<script>
export default {

  props: {
    items: {
      type: Array,
      default: null
    },

    setView: {
      type: Boolean,
      default: false
    }
  },

  data() {
    return {
      current: this.$router.currentRoute.path,
    }
  },

  methods: {
    change(target) {
      this.$router.push(target);
      
      if (this.$props.setView) {
        this.$parent.setView(this.$router.currentRoute.name)
      }

    },
  }
}
</script>
