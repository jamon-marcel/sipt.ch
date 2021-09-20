<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <div :class="isFetched ? 'is-loaded' : 'is-loading'">
      <header class="content-header flex-sb flex-vc">
        <h1>Rechnung erstellen</h1>
        <view-selector
          :items="[
            {route: '/administration/backoffice/modules', label: 'Module'},
            {route: '/administration/backoffice/invoices', label: 'Rechnungen'},
            //{route: '/administration/backoffice/import', label: 'Import'}
          ]"
        ></view-selector>
      </header>
      <div class="content content--wide">

        <div class="form-row">
          <a href="" @click.prevent="toggleWithOrWithoutBooking()" class="feather-icon feather-icon--prepend">
            <toggle-left-icon size="18" v-if="hasBooking"></toggle-left-icon>
            <toggle-right-icon size="18" v-if="!hasBooking"></toggle-right-icon>
            <span>Rechnung ohne Buchung?</span>
          </a>
        </div>

        <div class="form-row">
          <label>Rechnungs-Nummer</label>
          <input v-model="number" type="text">
          <label-info :text="'Leer lassen für autom. Nummer'"></label-info>
        </div>
        <div class="form-row">
          <label>Datum</label>
          <input type="text" v-model="date" v-cleave="{delimiter: '.', blocks: [2, 2, 4]}">
          <label-info :text="'Leer lassen für heutiges Datum'"></label-info>
        </div>
        <div class="form-row">
          <label>Betrag</label>
          <input type="text" v-model="amount" placeholder="z.B. 450">
        </div>
        <div class="form-row">
          <label>Buchungsnummer</label>
          <input type="text" v-model="booking_number" placeholder="z.B. 450011">
        </div>
        <div class="form-row">
          <label>Student suchen...</label>
          <input v-model="student_number" type="text" @blur="getStudent($event.target.value)">
          <label-info :text="'Nummer oder Name'"></label-info>
        </div>
        <div class="form-row">
          <label>...oder aus Liste wählen</label>
          <div class="select-wrapper is-wide">
            <select name="student_number" v-model="student" @change="getBookings($event.target.value)">
              <option value="null">Bitte wählen...</option>
              <option
                v-for="s in students"
                :key="s.id"
                :value="s.id"
              >{{ s.number }} - {{ s.name }} {{ s.firstname }}, {{ s.city }}, {{s.user.email}}</option>
            </select>
          </div>
        </div>
        <div class="form-row" v-if="hasBooking">
          <label>Buchungen</label>
          <div class="select-wrapper is-wide" v-if="isFetchedEvents && course_events != null">
            <select v-model="course_event_id">
              <option value="null">Bitte wählen...</option>
              <option
                v-for="(course_event, idx) in course_events"
                :value="course_event.pivot.course_event_id"
                :key="idx"
              >{{course_event.courseNumber}} – {{course_event.course.title | truncate(50, '...')}} vom {{ dateFormat(course_event.dateStart, 'DD.MM.YYYY')}}</option>
            </select>
          </div>
          <div v-else>
            <div class="no-records">Keine Buchungen gefunden...</div>
          </div>
        </div>
        <div v-if="!hasBooking">
          <div class="form-row">
            <label>Kursnummer</label>
            <input v-model="course_number" type="number" max="2" min="2" @blur="getCourse($event.target.value)">
            <div class="sb-sm" v-if="isFetchedEvents && course_events != null">
              <label>Kurs wählen</label>
              <div class="select-wrapper is-wide">
                <select v-model="course_event_id">
                  <option value="null">Bitte wählen...</option>
                  <option
                    v-for="(course_event, idx) in course_events"
                    :value="course_event.id"
                    :key="idx"
                  >{{course_event.courseNumber}} – {{course_event.course.title | truncate(50, '...')}} vom {{ dateFormat(course_event.dateStart, 'DD.MM.YYYY')}}</option>
                </select>
              </div>
            </div>
            <div class="sb-sm" v-else-if="isFetchedEvents">
              <div class="no-records">Keine Kurse gefunden...</div>
            </div>
          </div>
        </div>
      </div>
      <footer class="module-footer">
        <div class="flex-sb flex-vc">
          <button class="btn-primary" @click.prevent="create()">Speichern</button>
          <div v-if="file">
            <a :href="'/storage/invoices/' + file" target="_blank" class="btn-secondary has-icon">
              <download-icon size="16"></download-icon>
              <span>Rechnung herunterladen</span>
            </a>
          </div>
        </div>
      </footer>
    </div>
  </div>
</template>
<script>
// Icons
import { FilePlusIcon, DownloadIcon, ToggleLeftIcon, ToggleRightIcon} from "vue-feather-icons";

// Components
import ViewSelector from "@/administration/components/ViewSelector.vue";
import LabelRequired from "@/global/components/ui/LabelRequired.vue";
import LabelInfo from "@/global/components/ui/LabelInfo.vue";

// Mixins
import DateTime from "@/global/mixins/DateTime";
import Helpers from "@/global/mixins/Helpers";

export default {
  components: {
    ViewSelector,
    LabelInfo,
    LabelRequired,
    FilePlusIcon,
    DownloadIcon,
    ToggleLeftIcon,
    ToggleRightIcon
  },

  mixins: [DateTime, Helpers],

  data() {
    return {
      number: null,
      date: null,
      amount: null,
      students: null,
      student: null,
      student_number: null,
      booking_number: null,
      course_events: null,
      course_event_id: null,
      course_number: null,
      hasBooking: true,
      isLoading: false,
      isFetched: false,
      isFetchedEvents: false,
      file: null,
    };
  },

  created() {
    this.fetch();
  },

  methods: {
    fetch() {
      this.isLoading = true;
      this.axios.get(`/api/students`).then(response => {
        this.students = response.data.data;
        this.isLoading = false;
        this.isFetched = true;
      });
    },

    fetchBookings() {
      this.isLoading = true;
      this.axios.get(`/api/backoffice/student/bookings/${this.student}`).then(response => {
        this.course_events = response.data;
        this.isLoading = false;
        this.isFetchedEvents = true;
      });
    },

    getStudent(value) {
      if (value.length == 0) return;
      let v = value.charAt(0).toUpperCase() + value.slice(1)
      const idx = this.students.findIndex(x => x.number == v || x.name.includes(v));
      if (idx > -1) {
        this.student = this.students[idx].id;
        this.fetchBookings();
      }
    },

    getBookings(value) {
      if (this.hasBooking) {
        this.student = value;
        this.fetchBookings();
      }
    },

    getCourse(value) {
      this.isFetchedEvents = false;
      this.isLoading = true;
      this.axios.get(`/api/backoffice/course/by/number/${value}`).then(response => {
        this.course_events = response.data.events;
        this.isLoading = false;
        this.isFetchedEvents = true;
      });
    },

    create() {

      if (this.course_event_id == null) {
        this.$notify({ type: "error", text: "Buchung fehlt!" });
        return;
      }

      if (this.student == null) {
        this.$notify({ type: "error", text: "Student fehlt!" });
        return;
      }

      if (this.amount == null) {
        this.$notify({ type: "error", text: "Betrag fehlt!" });
        return;
      }
      
      let data = {
        courseEventId: this.course_event_id,
        studentId: this.student,
        number: this.number,
        date: this.date,
        amount: this.amount,
        booking_number: this.booking_number
      };

      this.isLoading = true;
      this.axios.post(`/api/backoffice/invoice/store`, data).then(response => {
        this.$notify({ type: "success", text: "Daten erfasst!" });
        this.isLoading = false;
        this.file = response.data;
        this.clear();
      });
    },

    clear() {
      this.number = null;
      this.date = null;
      this.amount = null;
      this.student = null;
      this.student_number = null;
      this.booking_number = null;
      this.course_events = null;
      this.course_event_id = null;
      this.course_number = null;
      this.hasBooking = true;
    },

    toggleWithOrWithoutBooking() {
      this.hasBooking = this.hasBooking ? false : true;
      if (this.hasBooking) {
        this.course_events = null;
      }
    }
  }
};
</script>
