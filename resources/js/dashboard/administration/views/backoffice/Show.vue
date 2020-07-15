<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <div :class="isFetched ? 'is-loaded' : 'is-loading'">
      <div class="content">
        <template v-if="isFetched">
          <h1>
            {{course_event.course.number}}.{{dateFormat(course_event.dateStart, 'DDMMYY')}} &mdash;   {{ course_event.course.title }}
          </h1>
          <h2 class="is-narrow">Ort</h2>
          <p>{{ course_event.location.name }}, {{ course_event.location.city }}</p>
          <h2 class="is-narrow">Daten</h2>
          <div class="listing">
            <div class="listing__item" v-for="date in course_event.dates" :key="date.id">
              <div class="listing__item-body">
                {{date.date}}
                <span class="separator">&bull;</span>
                {{date.timeStart}} – {{date.timeEnd}} Uhr
                <span class="separator">&bull;</span>
                {{date.tutor.title}} {{date.tutor.firstname}} {{date.tutor.name}}
              </div>
            </div>
          </div>

          <div class="flex-sb sb-md">
            <h2 class="is-narrow">Teilnehmer</h2>
          </div>
          <div v-if="course_event.students.length">
            <div class="listing">
              <div
                class="listing__item"
                v-for="student in course_event.students"
                :key="student.id"
              >
                <div class="listing__item-body">
                  {{student.firstname}} {{student.name}}
                  <span class="separator">&bull;</span>
                  {{student.title}}
                </div>
                <div class="listing__item-action">
                  <div>
                    <a
                      href="javascript:;"
                      @click.prevent="toggle(student.id, course_event.id)"
                    >
                      <span v-if="student.pivot.has_attendance" class="feather-icon is-active">
                        <check-circle-icon size="20"></check-circle-icon>
                      </span>
                      <span v-else>
                        <circle-icon size="20" class="feather-icon is-inactive"></circle-icon>
                      </span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div v-else>
            <p class="no-records">
             Es sind keine Teilnehmer für dieses Modul vorhanden...
            </p>
          </div>
        </template>
      </div>
      <footer class="module-footer">
        <div>
          <router-link :to="{ name: 'backoffice' }" class="btn-secondary">
            <span>Zurück</span>
          </router-link>
        </div>
      </footer>
    </div>
  </div>
</template>
<script>
// Icons
import { CheckCircleIcon, CircleIcon, DownloadCloudIcon } from "vue-feather-icons";

// Mixins
import Helpers from "@/global/mixins/Helpers";
import DateTime from "@/global/mixins/DateTime";

// Components
import ListActions from "@/global/components/ui/ListActions.vue";

export default {
  components: {
    CheckCircleIcon,
    CircleIcon,
    DownloadCloudIcon,
    ListActions
  },

  mixins: [Helpers, DateTime],

  data() {
    return {
      course_event: {},
      isLoading: false,
      isFetched: false
    };
  },

  mounted() {
    this.fetch();
  },

  methods: {
    fetch() {
      let uri = `/api/backoffice/course/event/${this.$route.params.id}`;
      this.axios.get(`${uri}`).then(response => {
        this.course_event = response.data;
        this.isFetched = true;
      });
    },

    toggle(studentId,courseEventId) {
      let uri = `/api/backoffice/student/attendance/${studentId}/${courseEventId}`;
      this.isLoading = true;
      this.axios.get(uri).then(response => {
        const idx = this.course_event.students.findIndex(x => x.id === studentId);
        this.course_event.students[idx].pivot.has_attendance = response.data;
        this.$notify({ type: "success", text: "Teilnahme-Status geändert" });
        this.isLoading = false;
      });
    },
  }
};
</script>
