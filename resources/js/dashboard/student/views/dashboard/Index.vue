<template>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <header class="content-header">
      <h1>Willkommen <strong>{{student.firstname}} {{student.name}}</strong></h1>
    </header>
    <div class="content">
      <p>Unser neues Portal für Studenten ermöglicht es Ihnen, ihre Daten selbständig zu aktualisieren sowie bequem neue Module zu buchen oder bestehende Buchungen anzupassen.</p>
      <h2 class="sb-md">Ihre nächsten Module</h2>
      <div class="listing" v-if="student.course_events">
        <div class="listing__item" v-for="c in student.course_events" :key="c.id">
          <div class="listing__item-body">
            {{c.dates}}
            <span class="separator">&bull;</span>
            {{ c.title }}
            <span class="separator">&bull;</span>
            {{ c.tutors }}
          </div>
        </div>
      </div>
      <div v-else>
        <p>Kein Module vorhanden!</p>
      </div>
    </div>
  </div>
</template>
<script>

// Mixins
import Helpers from "@/global/mixins/Helpers";

export default {

  mixins: [Helpers],

  data() {
    return {
      isFetched: false,
      student: {},
    };
  },

  created() {
    this.fetchStudent();
  },

  methods: {
    fetchStudent() {
      this.axios.get(`/api/student/courses/upcoming`).then(response => {
        this.student = response.data;
        this.student.course_events = 
          this.student.course_events.map(x => ({
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