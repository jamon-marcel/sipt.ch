<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <header class="content-header flex-sb flex-vc">
      <h1>Module</h1>
      <view-selector
        :items="[
          {route: '/administration/courses', label: 'Nach Nummer'},
          {route: '/administration/courses/chronological', label: 'Chronologisch'},
        ]"
        :setView="true"
      ></view-selector>
    </header>

    <!-- Order by number -->
    <div v-if="this.view == 'courses'">
      <div class="listing" v-if="courses.length">
        <div
          :class="[c.is_published == 0 ? 'is-disabled' : '', 'listing__item']"
          v-for="c in courses"
          :key="c.id"
        >
          <div class="listing__item-body">
            {{ c.number }} – {{ c.title | truncate(75, '...') }}
          </div>
          <list-actions
            :id="c.id" 
            :record="c"
            :hasEvent="true"
            :eventCount="c.events_upcoming.length"
            :routes="{edit: 'course-edit', events: 'course-events'}">
          </list-actions>
        </div>
      </div>
    </div>

    <!-- Order chronological -->
    <div v-if="this.view == 'courses-chronological'">
      <div class="listing" v-if="course_events.length">
        <div
          class="listing__item"
          v-for="c in course_events"
          :key="c.id"
        >
          <div :class="[c.students.length > c.max_participants ? 'color-danger' : 'listing__item-body']">
            {{ datesToString(c.dates) }}
            <separator />
            {{c.courseNumber}}
            <separator />
            {{c.course.title | truncate(50, '...')}}
            <separator />
            <span>
              {{c.students.length}}/{{c.max_participants}}
            </span>
            <em class="bubble-info" v-if="!c.is_bookable">geschlossen</em>
            <em class="bubble-warning" v-if="!c.is_published">autom. Versand deaktiviert</em>
          </div>
          <list-actions
            :id="c.id" 
            :record="c"
            :hasDetail="true"
            :hasDownload="true"
            :hasDestroy="false"
            :hasEdit="true"
            :hasToggle="false"
            :routes="{edit: 'course-event-edit', details: 'course-event-show', download: '/download/teilnehmerliste/' + c.id + '?v=' + randomString()}">
          </list-actions>
        </div>
      </div>
    </div>

    <footer class="module-footer">
      <div class="flex-sb flex-vc">
        <a :href="'/download/modulliste?v=' + randomString()" class="btn-primary has-icon" target="_blank">
          <download-icon size="16"></download-icon>
          <span>Download Modulliste</span>
        </a>
        <router-link :to="{ name: 'course-create' }" class="btn-secondary has-icon">
          <plus-icon size="16"></plus-icon>
          <span>Hinzufügen</span>
        </router-link>
      </div>
    </footer>
  </div>
</div>
</template>
<script>

// Icons
import { PlusIcon, DownloadIcon, DownloadCloudIcon, ArrowUpRightIcon, EditIcon } from 'vue-feather-icons';

// Components
import ListActions from "@/global/components/ui/ListActions.vue";
import ViewSelector from "@/administration/components/ViewSelector.vue";
import Helpers from "@/global/mixins/Helpers";

export default {

  components: {
    ListActions,
    PlusIcon,
    DownloadIcon,
    DownloadCloudIcon,
    ArrowUpRightIcon,
    EditIcon,
    ViewSelector
  },

  mixins: [Helpers],

  data() {
    return {
      courses: [],
      course_events: [],
      isLoading: false,
      isFetched: false,
      view: 'courses',
    };
  },

  created() {
    this.view = this.$router.currentRoute.name;
    this.fetch();
  },

  methods: {

    fetch() {

      if (this.view == 'courses') {
        this.isLoading = true;
        this.axios.get(`/api/courses`).then(response => {
          this.courses = response.data.data;
          this.isFetched = true;
          this.isLoading = false;
        });
      }

      if (this.view == 'courses-chronological') {
        this.isLoading = true;
        this.axios.get(`/api/course/events/fetch/upcoming`).then(response => {
          this.course_events = response.data.data;
          this.isFetched = true;
          this.isLoading = false;
        });
      }
    },

    toggle(id,event) {
      let uri = `/api/course/state/${id}`;
      this.isLoading = true;
      this.axios.get(uri).then(response => {
        const idx = this.courses.findIndex(x => x.id === id);
        this.courses[idx].is_published = response.data;
        this.$notify({ type: "success", text: "Status geändert" });
        this.isLoading = false;
      });
    },

    destroy(id, event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/course/${id}`;
        this.isLoading = true;
        this.axios.delete(uri).then(response => {
          this.fetch();
          this.isLoading = false;
        });
      }
    },

    setView(view) {
      this.view = view;
      this.fetch();
    }
  }
}
</script>