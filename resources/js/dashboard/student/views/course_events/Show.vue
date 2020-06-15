<template>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <div class="content">
      <template v-if="isFetched">
        <h1>Modul: <strong>{{ course_event.course.title }}</strong></h1>
        <h2 class="is-narrow">Beschreibung</h2>
        <p v-html="course_event.course.description">{{ course_event.course.description }}</p>
        <hr>
        <h2 class="is-narrow">Ort</h2>
        <p>{{ course_event.location.name }}, {{ course_event.location.city }}</p>
        <hr>
        <h2 class="is-narrow">Credits</h2>
        <p>{{ course_event.course.credits }}</p>
        <hr>
        <h2 class="is-narrow">Kosten</h2>
        <p>CHF {{ course_event.course.cost }}.–</p>
        <hr>
        <h2 class="is-narrow">Daten</h2>
        <div class="listing">
          <div class="listing__item" v-for="date in course_event.dates" :key="date.id">
            <div class="listing__item-body">
              {{date.date}} <span class="separator">&bull;</span>
              {{date.timeStart}} –  {{date.timeEnd}} Uhr <span class="separator">&bull;</span>
              {{date.tutor.title}} {{date.tutor.firstname}} {{date.tutor.name}}
            </div>
          </div>
        </div>
      </template>
    </div>
    <footer class="module-footer">
      <div>
        <a href="javascript:history.go(-1)" class="btn-secondary">
          <span>Zurück</span>
        </a>
      </div>
    </footer>
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
      course_event: {},
    };
  },

  mounted() {
    this.fetch();
  },

  methods: {
    fetch() {
      this.axios.get(`/api/student/course/show/${this.$route.params.id}`).then(response => {
        this.course_event = response.data;
        this.isFetched = true;
      });
    }
  }
}
</script>
