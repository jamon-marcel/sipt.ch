<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <div :class="isFetchedCoursesBooked && isFetchedStudent ? 'is-loaded' : 'is-loading'">
      <header class="content-header" v-if="isFetchedStudent">
        <div v-html="title">{{title}}</div>
      </header>
      <div class="content">
        <p>Eine Übersicht der bevorstehenden und absolvierten Module.</p>

        <template v-if="isFetchedCoursesBooked">
          <h2>Bevorstehende Module</h2>
          <course-events-list
            :records="courses.booked"
            :hasDetail="false"
            v-if="courses.booked.length"
          ></course-events-list>
          <div class="no-records" v-else>Es sind keine Module vorhanden...</div>
          <course-event-register :records="courses.booked" :studentId="student.id"></course-event-register>
        </template>

        <template v-if="isFetchedCoursesAttended">
          <h2>Absolvierte Module</h2>
          <course-events-list
            :records="courses.attended"
            :hasDetail="false"
            :hasDestroy="false"
            v-if="courses.attended.length"
          ></course-events-list>
          <div class="no-records" v-else>Es sind keine Module vorhanden...</div>
        </template>

      </div>
      <footer class="module-footer">
        <div>
          <router-link :to="{ name: 'students' }" class="btn-secondary">
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
import CourseEventsList from "@/global/components/CourseEventsList";
import CourseEventRegister from "@/global/components/CourseEventRegister";

export default {
  components: {
    CourseEventsList,
    CourseEventRegister
  },

  mixins: [Helpers],

  data() {
    return {
      courses: {
        booked: {},
        attended: {}
      },
      student: {},

      isFetched: false,
      isFetchedStudent: false,
      isFetchedCoursesBooked: false,
      isFetchedCoursesAttended: false,
      isLoading: false
    };
  },

  created() {
    this.fetch();
  },

  methods: {
    fetch() {
      // Get booked courses
      this.axios
        .get(`/api/student/course/events/booked/0/${this.$route.params.id}`)
        .then(response => {
          this.courses.booked = response.data.courseEvents;
          this.courses.booked = this.courses.booked.map(x => ({
            title: x.course.title,
            dates: this.datesToString(x.dates),
            tutors: this.tutorsToString(x.dates),
            isInvited: x.pivot.is_invited ? true : false,
            studentId: x.pivot.student_id,
            id: x.id
          }));
          this.isFetchedCoursesBooked = true;
        });

      // Get attended courses
      this.axios
        .get(`/api/student/course/events/attended/0/${this.$route.params.id}`)
        .then(response => {
          this.courses.attended = response.data.courseEvents;
          this.courses.attended = this.courses.attended.map(x => ({
            title: x.course.title,
            dates: this.datesToString(x.dates),
            tutors: this.tutorsToString(x.dates),
            hasAttendance: x.pivot.has_attendance ? true : false,
            studentId: x.pivot.student_id,
            id: x.id
          }));
          this.isFetchedCoursesAttended = true;
        });

      // Get student data
      this.axios.get(`/api/student/${this.$route.params.id}`).then(response => {
        this.student = response.data;
        this.isFetchedStudent = true;
      });
    },

    destroy(id) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/student/course/event/${id}/${this.$route.params.id}`;
        this.isLoading = true;
        this.axios.delete(uri).then(response => {
          this.fetch();
          this.$notify({ type: "success", text: "Modul entfernt!" });
          this.isLoading = false;
        });
      }
    }
  },

  computed: {
    title: function() {
      return (
        "<h1>Module für <strong>" +
        this.student.firstname +
        " " +
        this.student.name +
        "</strong></h1>"
      );
    }
  }
};
</script>