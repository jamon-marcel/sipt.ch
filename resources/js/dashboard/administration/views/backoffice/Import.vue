<template>
  <div>
    <div>
      <div>
        <small>{{prev}}</small>
      </div>
      <div class="form-row">
        <label>Student No.</label>
        <input v-model="number" type="text" @blur="getStudent($event.target.value)">
      </div>
      <div class="form-row">
        <label>Student</label>
        <div class="select-wrapper is-wide">
          <select name="student" v-model="student">
            <option value="null">Bitte wählen...</option>
            <option
              v-for="s in students"
              :key="s.id"
              :value="s.id"
            >{{ s.number }} - {{ s.name }} {{ s.firstname }}, {{ s.city }}, {{s.user.email}}</option>
          </select>
        </div>
      </div>
      <div class="form-row">
        <label>Course</label>
        <div class="select-wrapper is-wide">
          <select name="course" v-model="course">
            <optgroup
              :label="courses[index].number + '-' + courses[index].title"
              v-for="(course,index) in courses"
              :key="index"
            >
              <option
                v-for="(c, idx) in course.events_upcoming"
                :value="c.id"
                :key="idx"
              >{{course.number}}.{{ dateFormat(c.dateStart, 'DDMMYY')}}</option>
            </optgroup>
          </select>
        </div>
      </div>
      <div class="form-row">
        <label>Booking Number</label>
        <input type="text" v-model="booking_number">
      </div>
      <div class="form-row">
        <label>Date</label>
        <input type="text" v-model="date" v-cleave="{delimiter: '.', blocks: [2, 2, 4]}">
      </div>
      <div>
        <button class="btn-primary" @click.prevent="store()">Speichern</button>
      </div>
    </div>
    <div class="sb-lg">
      <div class="form-row">
        <label>Modul</label>
        <div class="select-wrapper is-wide">
          <select name="course" v-model="course_event_id" @change="getCourse($event.target.value)">
            <optgroup
              :label="courses[index].number + ' – ' + shorten(courses[index].title, 25)"
              v-for="(course,index) in courses"
              :key="index"
            >
              <option
                v-for="(c, idx) in course.events_upcoming"
                :value="c.id"
                :key="idx"
              >{{course.number}}.{{ dateFormat(c.dateStart, 'DDMMYY')}}</option>
            </optgroup>
          </select>
        </div>
      </div>
      <div v-if="isFetched">
        <h2>{{course_event.course.number}}.{{ dateFormat(course_event.dateStart, 'DDMMYY')}} – {{course_event.course.title}}<br>{{ course_event.students.length }} Anmeldungen</h2>
        <table class="listing">
          <thead>
            <th>Kunden Nr.</th>
            <th>Vorname, Name</th>
            <th>Ort</th>
            <th>E-Mail</th>
            <th>Buchung</th>
            <th style="text-align: right; padding-right: 0">Gebucht am</th>
          </thead>
          <tr v-for="(s, idx) in course_event.students" :key="idx">
            <td>{{s.number}}</td>
            <td>{{s.firstname}} {{s.name}}</td>
            <td>{{s.city}}</td>
            <td>{{s.user.email}}</td>
            <td>{{s.pivot.booking_number}}</td>
            <td style="text-align: right; padding-right: 0">{{ dateFormat(s.pivot.created_at, 'DD.MM.YYYY')}}</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import DateTime from "@/global/mixins/DateTime";
import Helpers from "@/global/mixins/Helpers";

export default {
  components: {},

  mixins: [DateTime, Helpers],

  data() {
    return {
      students: [],
      courses: [],

      number: null,
      student: null,
      course: null,
      booking_number: null,
      date: null,
      prev: null,

      course_event_id: null,
      course_event: {
        students: []
      },

      isFetched: false
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
      });
      this.axios.get(`/api/courses`).then(response => {
        this.courses = response.data.data;
        this.isLoading = false;
      });
    },

    store() {
      let data = {
        courseEventId: this.course,
        studentId: this.student,
        booking: this.booking_number,
        date: this.date
      };
      this.isLoading = true;
      this.axios.post(`/api/backoffice/import`, data).then(response => {
        this.$notify({ type: "success", text: "Daten erfasst!" });
        this.prev = `${this.number} ${this.booking_number} ${this.date}`;
        this.student = null;
        this.booking_number = 406;
        this.date = null;
        this.number = null;
        this.isLoading = false;
      });
    },

    getStudent(value) {
      const idx = this.students.findIndex(x => x.number == value);
      this.student = this.students[idx].id;
    },

    getCourse(course) {
      this.axios.get(`/api/course/event/${course}`).then(response => {
        this.course_event = response.data;
        this.isFetched = true;
      });
    }
  }
};
</script>
