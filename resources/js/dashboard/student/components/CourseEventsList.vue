<template>
  <div class="listing" v-if="$props.records">
    <div class="listing__item" v-for="r in $props.records" :key="r.id" :data-icons="iconCount">
      <div class="listing__item-body">
        {{r.dates}}
        <span class="separator">&bull;</span>
        {{ r.title }}
        <span class="separator">&bull;</span>
        {{ r.tutors }}
      </div>
      <list-actions
        :id="r.id"
        :count="iconCount"
        :hasEdit="false"
        :hasToggle="false"
        :hasDetail="true"
        :hasDestroy="$props.hasDestroy"
        :record="{id: r}"
        :routes="{details: 'course-show'}"
      ></list-actions>
    </div>
  </div>
</template>
<script>

// Components
import ListActions from "@/global/components/ui/ListActions.vue";

export default {
  components: {
    ListActions
  },

  data() {
    return {
      iconCount: 2,
    }
  },

  props: {
    records: null,
    hasDestroy: {
      type: Boolean,
      default: true,
    }
  },

  mounted() {
    this.iconCount = this.$props.hasDestroy ? 2 : 1;
  },

  methods: {
    destroy(id,$event) {
      this.$parent.destroy(id,$event);
    }
  }
};
</script>