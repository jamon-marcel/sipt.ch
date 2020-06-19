<template>

  <div v-if="isTutor">
    <div class="listing" v-if="$props.records">
      <div class="listing__item" v-for="r in $props.records" :key="r.id">
        <div class="listing__item-body">
          <span class="item-date">{{r.date}}</span>
          <span class="separator">&bull;</span>
          {{ r.course_event.course.title }}
        </div>
        <list-actions
          :id="r.course_event.id "
          :hasEdit="false"
          :hasToggle="false"
          :hasDetail="true"
          :hasDestroy="false"
          :record="{id: r}"
          :routes="{details: 'course-show'}"
        ></list-actions>
      </div>
    </div>
  </div>

  <div v-else>
    <div class="listing" v-if="$props.records">
      <div class="listing__item" v-for="r in $props.records" :key="r.id">
        <div class="listing__item-body">
          <span class="item-date">{{r.dates}}</span>
          <span class="separator">&bull;</span>
          {{ r.title }}
          <span class="separator">&bull;</span>
          {{ r.tutors }}
        </div>
        <list-actions
          :id="r.id"
          :hasEdit="false"
          :hasToggle="false"
          :hasDetail="$props.hasDetail"
          :hasDestroy="$props.hasDestroy"
          :record="{id: r}"
          :routes="{details: 'course-event-show'}"
        ></list-actions>
      </div>
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

  props: {
    records: null,

    hasDestroy: {
      type: Boolean,
      default: true,
    },

    hasDetail: {
      type: Boolean,
      default: true,
    },

    isTutor: {
      type: Boolean,
      default: false
    }
  },

  methods: {
    destroy(id,$event) {
      this.$parent.destroy(id,$event);
    }
  }
};
</script>