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

        <div v-if="$props.isStudent">
          <h2 class="is-narrow">Credits</h2>
          <p>{{ course_event.course.credits }}</p>
          <hr>
          <h2 class="is-narrow">Kosten</h2>
          <p>CHF {{ course_event.course.cost }}.–</p>
          <hr>
        </div>

        <div v-if="$props.isAdmin">
          <h2 class="is-narrow">Max. Teilnehmer</h2>
          <p>{{ course_event.max_participants }}</p>
          <hr>
        </div>

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

        <div v-if="$props.isAdmin">
          <div class="flex-sb sb-md">
            <h2 class="is-narrow">
              Angemeldete Teilnehmer <em v-if="course_event.students.length">({{course_event.students.length}})</em>
            </h2>
            <a href="" class="feather-icon feather-icon--prepend">
              <users-icon size="16"></users-icon>
              <span>Teilnehmerliste</span>
            </a>
          </div>
          <div v-if="course_event.students.length">
            <div class="listing">
              <div class="listing__item" v-for="student in course_event.students" :key="student.id">
                <div class="listing__item-body">
                  {{student.firstname}} {{student.name}}<span class="separator">&bull;</span>
                  {{student.title}}
                </div>
              </div>
            </div>
          </div>
          <div v-else>
            <p class="no-records">Es haben sich noch keine Teilnehmer für dieses Modul angemeldet...</p>
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

// Icons
import { UsersIcon } from 'vue-feather-icons';

// Mixins
import Helpers from "@/global/mixins/Helpers";

export default {

  components: {
    UsersIcon
  },

  props: {
    
    isStudent: {
      type: Boolean,
      default: false,
    },
    
    isAdmin: {
      type: Boolean,
      default: false,
    },

    isTutor: {
      type: Boolean,
      default: false,
    },

    id: {
      type: String,
      default: null,
    }
  },

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

      if (this.$props.isStudent) {
       let uri = `/api/student/course/event/${this.$props.id}`;
        this.axios.get(`${uri}`).then(response => {
          this.course_event = response.data;
          this.isFetched = true;
        });
      }

      if (this.$props.isTutor) {
        let uri = `/api/tutor/course/event/${this.$props.id}`;
        this.axios.get(`${uri}`).then(response => {
          this.course_event = response.data.course_event;
          this.isFetched = true;
        });
      }

      if (this.$props.isAdmin) {
        let uri = `/api/course/event/${this.$props.id}`;
        this.axios.get(`${uri}`).then(response => {
          this.course_event = response.data;
          this.isFetched = true;
        });
      }
    }
  }
}
</script>
