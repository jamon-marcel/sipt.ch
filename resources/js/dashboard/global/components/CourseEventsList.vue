<template>
<div>
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

    <div class="overlay is-visible" v-if="hasOverlay">
      <div class="overlay__inner">
        <div>
          <a href @click.prevent="hideOverlay()" class="feather-icon">
            <x-icon size="24"></x-icon>
          </a>
          <h2>Stornierung ohne Kostenfolge?</h2>
          <p>Soll die Buchung mit oder ohne Kostenfolge storniert werden?</p>
          <div class="flex sb-sm">
            <button class="btn-primary is-sm" @click.prevent="destroyWithCost()">Mit Kostenfolge</button>
            &nbsp;&nbsp;
            <button class="btn-secondary is-sm" @click.prevent="destroyWithoutCost()">Ohne Kostenfolge</button>
          </div>
        </div>
      </div>
    </div>

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
</div>
</template>
<script>

// Icons
import { XIcon } from "vue-feather-icons";

// Components
import ListActions from "@/global/components/ui/ListActions.vue";

export default {

  components: {
    ListActions,
    XIcon
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
    },

    isAdmin: {
      type: Boolean,
      default: false,
    }
  },

  data() {
    return {
      hasOverlay: false,
      overlayRecord: null,
      destroyWithoutPenalty: false,
    };
  },


  methods: {
    destroy(id,$event) {
      if (this.$props.isAdmin) {
        this.hasOverlay = true;
        this.overlayRecord = id;
        return;
      }
      else {
        this.$parent.destroy(id,$event)
      }
    },

    destroyWithoutCost() {
      this.$parent.destroyWithoutCost(this.overlayRecord,true);
      this.overlayRecord = null;
      this.hideOverlay();
    },

    destroyWithCost() {
      this.$parent.destroy(this.overlayRecord);
      this.overlayRecord = null;
      this.hideOverlay();
    },

    hideOverlay() {
      this.hasOverlay = false;
    }
  }
};
</script>