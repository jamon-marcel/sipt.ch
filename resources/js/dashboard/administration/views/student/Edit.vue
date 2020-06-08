<template>
<div>
  <form @submit.prevent="submit">
    <header class="module-header">
      <h1 v-if="isFetched" v-html="title">{{title}}</h1>
    </header>
    <div class="grid-main-sidebar">
      <div>
        <template v-if="isFetched">
          <course-events
            v-bind:courses.sync="student.course_events"
            :label="'Modul hinzufügen'"
            :labelSelected="'Module'"
            :data="student.course_events"
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
// Error Handling (mixin)
import ErrorHandling from "@/global/mixins/ErrorHandling";
import DateTime from "@/global/mixins/DateTime";

// Components
import CourseEvents from "@/administration/components/CourseEvents.vue";

export default {
  components: {
    CourseEvents,
  },

  mixins: [ErrorHandling, DateTime],

  data() {
    return {
      // Model
      student: {

      },

      // Validation
      errors: {

      },

      // Lazy loading
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
      return 'Module für <strong>' + this.student.firstname + ' ' + this.student.name + '</strong> verwalten';
    }
  }
};
</script>