<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <header class="content-header">
      <h1>Modul: <strong>{{course.title}}</strong></h1>
    </header>
    <template v-if="isFetched">
      <header class="flex-sb">
        <h2 class="is-narrow">Veranstaltungen</h2>
        <router-link :to="{ name: 'course-event-create', params: { id: course.id } }" class="feather-icon feather-icon--prepend">
          <plus-icon size="16"></plus-icon>
          <span>Hinzufügen</span>
        </router-link>
      </header>
      <div class="listing" v-if="events_upcoming">
        <div
          :class="[c.is_published == 0 ? 'is-disabled' : '', 'listing__item']"
          v-for="c in events_upcoming"
          :key="c.id"
        >
          <div class="listing__item-body">
            <span class="item-date" v-if="c.dates.length">{{ datesToString(c.dates) }}</span>
            <span class="item-date" v-else>Keine Daten...</span>
            <span class="separator">&bull;</span>

            <span v-if="c.location_id != 'null' && c.is_online == 0">{{ c.location.name_short }}, {{ c.location.city }}</span>
            <span v-else>Online</span>
            <span class="separator">&bull;</span>
            
            {{ tutorsToString(c.dates) }}
            <em class="bubble-danger" v-if="c.is_cancelled">Abgesagt</em>
            <em class="bubble-info" v-if="!c.is_bookable">Registration Geschlossen</em>
          </div>
          <list-actions
            :id="c.id" 
            :record="c"
            :hasDetail="true"
            :routes="{edit: 'course-event-edit', details: 'course-event-show'}">
          </list-actions>
        </div>
      </div>  
      <div v-else>
        <p class="no-records">Es sind keine bevorstehenden Veranstaltungen für dieses Modul vorhanden...</p>
      </div>
      <header class="flex-sb sb-sm">
        <a href="" @click.prevent="toggleCompleted()" class="is-narrow sa-xs feather-icon feather-icon--prepend">
          <chevron-down-icon size="16" v-if="showCompleted"></chevron-down-icon>
          <chevron-right-icon size="16" v-if="!showCompleted"></chevron-right-icon>
          <span>Vergangene Veranstaltungen</span>
        </a>
      </header>
      <div class="listing" v-if="showCompleted">
        <div
          :class="[c.is_published == 0 ? 'is-disabled' : '', 'listing__item']"
          v-for="c in events_completed"
          :key="c.id"
        >
          <div class="listing__item-body">
            <span class="item-date">{{ datesToString(c.dates) }}</span>
            <span class="separator">&bull;</span>
            <span v-if="c.location_id != 'null' && c.is_online == 0">{{ c.location.name_short }}, {{ c.location.city }}</span>
            <span v-else>Online</span>
            <span class="separator">&bull;</span>
            {{ tutorsToString(c.dates) }}
            <em class="bubble-danger" v-if="c.is_cancelled">Abgesagt</em>
          </div>
          <list-actions
            :id="c.id" 
            :record="c"
            :hasDetail="false"
            :hasDestroy="false"
            :hasToggle="false"
            :routes="{edit: 'course-event-edit', details: 'course-event-show'}">
          </list-actions>
        </div>
      </div>  
    </template>
    <footer class="module-footer">
      <div>
        <router-link :to="{ name: 'courses' }" class="btn-secondary">
          <span>Zurück</span>
        </router-link>
      </div>
    </footer>
  </div>
</div>
</template>
<script>

// Icons
import { PlusIcon, ArrowLeftIcon, ChevronDownIcon, ChevronRightIcon } from 'vue-feather-icons';

// Components
import ListActions from "@/global/components/ui/ListActions.vue";

// Mixins
import Helpers from "@/global/mixins/Helpers";

export default {

  components: {
    ListActions,
    PlusIcon,
    ArrowLeftIcon,
    ChevronDownIcon,
    ChevronRightIcon
  },

  mixins: [Helpers],

  data() {
    return {
      course: {},
      events_upcoming: {},
      events_completed: {},

      isFetched: false,
      isLoading: false,

      showCompleted: false,
    };
  },

  created() {
    this.fetch();
  },

  methods: {

    fetch() {
      this.axios.get(`/api/course/with/events/${this.$route.params.id}`).then(response => {
        this.course = response.data.course;
        this.events_upcoming = response.data.events.upcoming;
        this.events_completed = response.data.events.completed;
        this.isFetched = true;
      });
    },

    toggle(id,event) {
      let uri = `/api/course/event/state/${id}`;
      this.isLoading = true;
      this.axios.get(uri).then(response => {
        const idx = this.events_upcoming.findIndex(x => x.id === id);
        this.events_upcoming[idx].is_published = response.data;
        this.$notify({ type: "success", text: "Status geändert" });
        this.isLoading = false;
      });
    },

    destroy(id, event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/course/event/${id}`;
        this.isLoading = true;
        this.axios.delete(uri).then(response => {
          this.fetch();
          this.isLoading = false;
        });
      }
    },

    toggleCompleted() {
      this.showCompleted = this.showCompleted ? false : true;
    }
  }
}
</script>