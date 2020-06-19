<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <div :class="isFetchedCoursesBooked ? 'is-loaded' : 'is-loading'">
      <header class="content-header">
        <div v-html="title">{{title}}</div>
      </header>
      <div class="content">
        <p>Eine Übersicht Ihrer bevorstehenden und absolvierten Module.</p>
        <template v-if="isFetchedCoursesBooked">
          <h2>Bevorstehende Module</h2>
          <course-events-list :records="courses.booked" :hasDetail="true"></course-events-list>
          <course-event-register :records="courses.booked"></course-event-register>
        </template>
        <template v-if="isFetchedCoursesAttended">
          <h2>Absolvierte Module</h2>
          <course-events-list :records="courses.attended" :hasDetail="false" :hasDestroy="false"></course-events-list>
        </template>
        <div class="sb-md">
          <a href="" class="feather-icon feather-icon--prepend is-highlight">
            <award-icon size="16"></award-icon>
            <span>Ausbildungsblatt herunterladen</span>
          </a>
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
  </div>
</template>
<script>

// Icons
import { AwardIcon } from 'vue-feather-icons';

// Mixins
import Helpers from "@/global/mixins/Helpers";
import DateTime from "@/global/mixins/DateTime";

// Components
import CourseEventsList from "@/global/components/CourseEventsList";
import CourseEventRegister from "@/global/components/CourseEventRegister";

export default {
  components: {
    CourseEventsList,
    CourseEventRegister,
    AwardIcon
  },

  mixins: [Helpers, DateTime],

  data() {
    return {
      
      courses: {
        booked: {},
        attended: {}
      },

      isFetched: false,
      isFetchedCoursesBooked: false,
      isFetchedCoursesAttended: false,
      isLoading: false,

      cancellationDeadline: 14,
    };
  },

  created() {
    this.fetch();
  },

  methods: {
    fetch() {
      // Get booked courses
      this.axios.get(`/api/student/course/events/booked`).then(response => {
        this.courses.booked = response.data.courseEvents.map(x => ({
          title: x.course.title,
          dates: this.datesToString(x.dates),
          tutors: this.tutorsToString(x.dates),
          hasCancelFee: this.hasCancelFee(x.dates),
          id: x.id
        }));
        this.isFetchedCoursesBooked = true;
      });

      // Get attended courses
      this.axios.get(`/api/student/course/events/attended`).then(response => {
        this.courses.attended = response.data.courseEvents.map(x => ({
          title: x.course.title,
          dates: this.datesToString(x.dates),
          tutors: this.tutorsToString(x.dates),
          id: x.id
        }));
        this.isFetchedCoursesAttended = true;
      });
    },

    destroy(id) {
      if (confirm("Bitte löschen bestätigen!")) {
        
        // Show message if cancellaction fee occurs
        let coursesBooked = this.courses.booked, 
            idx = coursesBooked.findIndex(x => x.id === id);
        
        if (idx !== -1 && coursesBooked[idx].hasCancelFee) {

        }

        let uri = `/api/student/course/event/${id}`;
        this.isLoading = true;
        this.axios.delete(uri).then(response => {
          this.fetch();
          this.$notify({ type: "success", text: "Modul entfernt!" });
          this.isLoading = false;
        });
      }
    },

    hasCancelFee(data) {
      let date = data.map(x => x.date).shift();
      if (this.dateDifferenceFromNow(date) < this.cancellationDeadline) {
        return true;
      }
      return false;
    }
  },

  computed: {
    title: function() {
      return "<h1>Ihre Module</h1>";
    }
  }
};
</script>