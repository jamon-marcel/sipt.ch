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
      isFetched: false,
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
    },
  },
};
</script>