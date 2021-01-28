<template>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <header class="content-header">
      <h1>Ihre Module</h1>
    </header>
    <div class="content">
      <p>Eine Übersicht Ihrer bevorstehenden Module.</p>
      <course-events-list
        :records="courseEvents"
        :isTutor="true"
        :hasDestroy="false"
        v-if="courseEvents.length"
      ></course-events-list>
      <div class="no-records" v-else>Keine Module vorhanden...</div>
      <p class="sb-md">
        <a href="javascript:;" @click.prevent="togglePastEvents()">Abgeschlossene Module anzeigen</a>
      </p>
      <course-events-list
        :records="courseEventsPast"
        :isTutor="true"
        :hasDestroy="false"
        v-if="courseEventsPast.length && displayPastEvents"
      ></course-events-list>
      <div v-if="!courseEventsPast.length">
        <div class="no-records">Keine Module vorhanden...</div>
      </div>
    </div>
    <footer class="module-footer">
      <div>
        <router-link :to="{ name: 'home' }" class="btn-secondary">
          <span>Zurück</span>
        </router-link>
      </div>
    </footer>
  </div>
</template>
<script>

// Mixins
import Helpers from "@/global/mixins/Helpers";

// Components
import CourseEventsList from "@/global/components/CourseEventsList";

export default {
  components: {
    CourseEventsList,
  },

  data() {
    return {
      courseEvents: {},
      courseEventsPast: {},
      isFetched: false,
      displayPastEvents: false,
    };
  },

  created() {
    this.fetch();
  },

  methods: {
    fetch() {
      this.axios.get(`/api/tutor/course/events/upcoming`).then(response => {
        this.courseEvents = response.data.courseEvents;
        this.isFetched = true;
      });

      this.axios.get(`/api/tutor/course/events/past`).then(response => {
        this.courseEventsPast = response.data.courseEvents;
      });
    },

    togglePastEvents() {
      this.displayPastEvents = this.displayPastEvents ? false : true;
    }
  },
};
</script>