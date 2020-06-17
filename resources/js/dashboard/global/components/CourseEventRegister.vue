<template>
  <div>
    <div class="widget-course-register">
      <div class="flex-fe sa-sm">
        <a href class="btn-primary has-icon is-sm" @click.prevent="toggleForm()">
          <shopping-cart-icon size="16"></shopping-cart-icon>
          <span>Modul hinzufügen</span>
        </a>
      </div>
      <div class="course-register" v-if="isVisible">
        <loading-indicator :classNames="'is-widget'" :iconSize="'24'" v-if="isLoading"></loading-indicator>
        <div class="course-register__intro">
          <h2>Modul hinzufügen</h2>
          <p>Fügen Sie mit wenigen Schritten ein neues Modul hinzu. Neue Module können bis 2 Wochen vor Beginn hinzugefügt werden.</p>
        </div>
        <div class="course-register__select" v-if="trainings.length">
          <h3>Ihre Ausbildungsrichtung?</h3>
          <div class="select-wrapper is-wide">
            <select v-model="training" name="trainings" @change="fetchCourses($event.target.value)">
              <option value="null">Bitte wählen...</option>
              <optgroup
                :label="trainings[0].category.name"
                v-for="(trainings,index) in groupedTrainings"
                :key="index"
              >
                <option
                  v-for="(training, idx) in trainings"
                  :value="training.id"
                  :key="idx"
                >{{ training.title }}</option>
              </optgroup>
            </select>
          </div>
        </div>
        <div class="course-register__select" v-if="courses.length">
          <h3>Welches Modul?</h3>
          <div class="select-wrapper is-wide">
            <select
              v-model="course"
              name="courses"
              @change="fetchCourseEvents($event.target.value)"
            >
              <option value="null">Bitte wählen...</option>
              <option
                v-for="(course, idx) in courses"
                :value="course.id"
                :key="idx"
              >{{ course.title }}</option>
            </select>
          </div>
        </div>
        <div class="course-register__select" v-if="course_events.length">
          <h3>Wann?</h3>
          <div class="course-register__items">
            <div v-for="(course_event, idx) in course_events" :value="course_event.id" :key="idx">
              <div>
                <label>Datum</label>
                {{ datesToString(course_event.dates) }}
              </div>
              <div>
                <label>Dozent(en)</label>
                {{ tutorsToString(course_event.dates) }}
              </div>
              <div>
                <label>Ort</label>
                {{ course_event.location.name_short }}
              </div>
              <div>
                <a
                  href
                  class="btn-primary is-sm"
                  @click.prevent="storeCourseEvent(course_event.id)"
                >
                  <span>Hinzufügen</span>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="no-records" v-if="no_records">Im Moment sind keine Daten für das gewünschte Modul vorhanden...</div>
      </div>
    </div>
  </div>
</template>
<script>

// Icons
import { ShoppingCartIcon } from 'vue-feather-icons';

// Mixins
import Helpers from "@/global/mixins/Helpers";
import ErrorHandling from "@/global/mixins/ErrorHandling";

export default {
  components: {
    ShoppingCartIcon
  },

  props: {
    records: null,
    studentId: null
  },

  mixins: [Helpers, ErrorHandling],

  data() {
    return {
      isVisible: false,

      trainings: [],
      courses: [],
      course_events: [],

      training: null,
      course: null,

      no_records: false,

      // status
      isLoading: false
    };
  },

  methods: {
    // Fetch trainings
    fetch() {
      this.isLoading = true;
      this.axios.get(`/api/trainings`).then(response => {
        this.trainings = response.data.data;
        this.isLoading = false;
      });
    },

    // Fetch courses by training
    fetchCourses(id) {
      this.course = null;
      this.courses = [];
      this.course_events = [];
      this.no_records = false;
      if (id == "null") return;
      this.isLoading = true;
      this.axios.get(`/api/courses/by/training/${id}`).then(response => {
        this.courses = response.data;
        this.isLoading = false;
        if (this.courses.length == 0) {
          this.no_records = true;
        }
      });
    },

    // Fetch courseEvents by course
    fetchCourseEvents(id) {
      this.course_events = [];
      this.no_records = false;
      if (id == "null") return;
      this.isLoading = true;
      this.axios
        .get(`/api/course/events/by/course/${id}`)
        .then(response => {
          this.course_events = response.data.events_bookable;
          if (this.course_events.length && this.records.length) {
            let _that = this;
            this.course_events = this.course_events.filter(function(item) {
              return (
                _that.$props.records.findIndex(x => x.id === item.id) === -1
              );
            });
          }

          if (this.course_events.length == 0) {
            this.no_records = true;
          }
          this.isLoading = false;
        });
    },

    storeCourseEvent(id) {
      let uri = this.$props.studentId
        ? `/api/student/store/course/event/${this.$props.studentId}`
        : `/api/student/store/course/event`;
      this.isLoading = true;
      this.axios.post(uri, { courseEventId: id }).then(response => {
        this.$notify({ type: "success", text: "Modul hinzugefügt!" });
        this.$parent.fetch();
        this.reset();
        this.isLoading = false;
      });
    },

    reset() {
      this.course_events = [];
      this.courses = [];
      this.trainings = [];
      this.course = null;
      this.training = null;
      this.no_records = false;
      this.isVisible = false;
    },

    toggleForm() {
      this.isVisible = this.isVisible ? false : true;
      if (this.isVisible) {
        this.fetch();
      }
    }
  },

  computed: {
    groupedTrainings() {
      return _.groupBy(this.trainings, "category_id");
    }
  }
};
</script>
