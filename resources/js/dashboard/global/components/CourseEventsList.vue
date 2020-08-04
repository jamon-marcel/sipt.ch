<template>

  <div v-if="isTutor">
    <div class="listing" v-if="$props.records">
      <div class="listing__item" v-for="r in $props.records" :key="r.id">
        <div class="listing__item-body">
          <span class="item-date">{{r.date}}</span>
          <separator />
          {{ r.course_event.course.title | truncate(70, '...') }}
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
          <separator />
          {{ r.title | truncate(50, '...') }}
          <separator />
          {{ r.tutors }}
        </div>
        <list-actions
          :id="r.id"
          :hasEdit="false"
          :hasToggle="false"
          :hasDetail="$props.hasDetail"
          :hasDestroy="$props.hasDestroy"
          :hasInvitation="r.isInvited"
          :hasAttendance="r.hasAttendance"
          :record="{id: r}"
          :routes="{details: 'course-event-show', invitation: '/download/kurseinladung/' + r.id, attendance: '/download/kursbestaetigung/' + r.id}"
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

    hasInvitation: {
      type: Boolean,
      default: false,
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