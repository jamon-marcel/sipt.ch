<template>
  <div class="listing__item-action" :data-icons="count">
    <div v-if="hasToggle">
      <a
        href="javascript:;"
        :class="[record.is_published == 1 ? 'icon-eye' : 'icon-eye-off', 'icon-mini']"
        @click.prevent="toggle(record.id,$event)"
      ></a>
    </div>
    <div v-if="hasEdit">
      <router-link
        :to="{name: routes.edit, params: { id: record.id }}"
        class="icon-edit icon-mini"
      ></router-link>
    </div>
    <div v-if="hasDestroy">
      <a
        href="javascript:;"
        class="icon-trash icon-mini"
        @click.prevent="destroy(record.id,$event)"
      ></a>
    </div>
  </div>
</template>
<script>
export default {

  props: {
    count: {
      type: Number,
      default: 1
    },
    
    hasEdit: {
      type: Boolean,
      default: true
    },
    
    hasDestroy: {
      type: Boolean,
      default: true
    },
    
    hasToggle: {
      type: Boolean,
      default: true
    },

    routes: Object,
    record: Object,
  },

  methods: {

    toggle(id,$event) {
      this.$parent.toggle(id,$event);
    },

    destroy(id,$event) {
      this.$parent.destroy(id,$event);
    }
  }
}
</script>

