<template>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <header class="content-header">
      <h1>Willkommen <strong>{{student.firstname}} {{student.name}}</strong></h1>
    </header>
    <div class="content">
      <p>Unser neues Portal für Studenten ermöglicht es Ihnen, ihre persönlichen Daten selbständig zu aktualisieren sowie ganz einfach und schnell neue Module zu buchen oder bestehende anzupassen.</p>
      <h2 class="sb-md">Ihre nächsten Module</h2>
      <course-events-list :records="courseEvents" :hasDestroy="false"></course-events-list>
      <div v-if="courseEvents" class="flex-fe">
        <router-link :to="{name: 'courses'}">
          <span>Alle anzeigen</span>
        </router-link>
      </div>
    </div>
  </div>
</template>
<script>

// Icons
import { ArrowUpRightIcon } from 'vue-feather-icons';

// Mixins
import Helpers from "@/global/mixins/Helpers";

// Components
import CourseEventsList from "@/global/components/CourseEventsList";

export default {

  components: {
    ArrowUpRightIcon,
    CourseEventsList
  },

  mixins: [Helpers],

  data() {
    return {
      isFetched: false,
      student: {},
      courseEvents: {},
    };
  },

  created() {
    this.fetch();
  },

  methods: {
    fetch() {
      this.axios.get(`/api/student/courses/upcoming/3`).then(response => {
        this.student = response.data.student;
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
    }
  }
}
</script>