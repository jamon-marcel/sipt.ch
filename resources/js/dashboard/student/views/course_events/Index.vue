<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">

    <header class="content-header">
      <h1>Ihre Module</h1>
    </header>

    <div class="content">
      <p>Eine Übersicht Ihrer gebuchten und bereits besuchten Module.</p>
      <h2 class="sb-md">Gebuchte Module</h2>
      <course-events-list :records="courseEvents" v-if="isFetched"></course-events-list>
      <course-event-register :records="courseEvents" v-if="isFetched"></course-event-register>
    </div>

    <footer class="module-footer">
      <div>
        <router-link :to="{ name: 'home' }" class="btn-secondary">
          <span>Zurück</span>
        </router-link>
      </div>
    </footer>

  </div>
</div>
</template>
<script>

// Mixins
import Helpers from "@/global/mixins/Helpers";

// Components
import CourseEventsList from "@/student/components/CourseEventsList";
import CourseEventRegister from "@/student/components/CourseEventRegister";

export default {

  components: {
    CourseEventsList,
    CourseEventRegister,
  },

  mixins: [Helpers],

  data() {
    return {
      isFetched: false,
      isLoading: false,
      courseEvents: {},
    };
  },

  created() {
    this.fetch();
  },

  methods: {
    fetch() {
      this.axios.get(`/api/student/booked/courses`).then(response => {
        this.courseEvents = response.data.courseEvents;
        this.courseEvents = 
          this.courseEvents.map(x => ({
            title: x.course.title,
            dates: this.datesToString(x.dates),
            tutors: this.tutorsToString(x.dates),
            id: x.id
          }))
        ;
        this.isFetched = true;
      });
    },

    destroy(id) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/student/remove/course/event/${id}`;
        this.isLoading = true;
        this.axios.delete(uri).then(response => {
          this.fetch();
          this.$notify({ type: "success", text: "Modul entfernt!" });
          this.isLoading = false;
        });
      }
    }
  }
}
</script>