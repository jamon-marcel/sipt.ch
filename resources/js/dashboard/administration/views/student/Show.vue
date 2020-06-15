<template>
<div :class="isFetched ? 'is-loaded' : 'is-loading'">
  <form @submit.prevent="submit">
    <div class="grid-main-sidebar profile">
      <div>
        <header class="content-header">
          <h1>Profil</h1>
        </header>
        <profile :student="student"></profile>
        <hr>
        <header class="content-header">
          <h1>Besuchte Module</h1>
        </header>
        <p class="no-records">{{ student.firstname }} {{ student.name }} hat noch keine Module besucht...</p>
        <hr>
        <template v-if="isFetched">
          <course-events
            :label="'Gebuchte Module'"
            :records="student.course_events"
          ></course-events>
        </template>
      </div>
    </div>
    <footer class="module-footer">
      <div>
        <button type="submit" class="btn-primary">Speichern</button>
        <router-link :to="{ name: 'students' }" class="btn-secondary">
          <span>Zurück</span>
        </router-link>
      </div>
    </footer>
  </form>
</div>
</template>
<script>
// Mixins
import Helpers from "@/global/mixins/Helpers";

// Components
import CourseEvents from "@/administration/components/CourseEvents.vue";

// Views
import Profile from "@/student/views/partials/Profile.vue";

export default {
  components: {
    CourseEvents,
    Profile,
  },

  mixins: [Helpers],

  data() {
    return {
      student: {},
      errors: { },
      isFetched: true,
    };
  },

  created() {
    this.isFetched = false;
    let uri = `/api/student/courses/${this.$route.params.id}`, _that = this;
    this.axios.get(uri).then(response => {
      this.student = response.data;
      this.student.course_events = 
        this.student.course_events.map(x => ({
          title: x.course.title,
          dates: this.datesToString(x.dates),
          id: x.id
        }))
      ;
      this.isFetched = true;
    });
  },

  methods: {
    submit() {
      this.update();
    },

    update() {
      let uri = `/api/student/update/course/events`;
      this.axios.post(uri, this.student).then(response => {
        this.$router.push({ name: "students" });
        this.$notify({ type: "success", text: "Änderungen gespeichert!" });
      });
    },

    addCourse(course) {
      this.student.course_events.push(course);
    },

    removeCourse(id) {
      const idx = this.student.course_events.findIndex(x => x.id === id);
      this.student.course_events.splice(idx, 1);
    }
  },

  computed: {
    title: function() {
      return '<strong>' + this.student.firstname + ' ' + this.student.name + '</strong> verwalten';
    }
  }
};
</script>