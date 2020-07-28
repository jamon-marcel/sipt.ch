<template>
<div>
  <div class="form-row">
    <label>Student</label>
    <div class="select-wrapper is-wide">
      <select name="student" v-model="student">
        <option value="null">Bitte wählen...</option>
        <option v-for="s in students" :key="s.id" :value="s.id">
          {{ s.number }} - {{ s.name }} {{ s.firstname }}, {{ s.city }}, {{s.user.email}}
        </option>
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
    <input type="text" v-model="date">
  </div>
  <div>
    <button class="btn-primary" @click.prevent="store()">Speichern</button>
  </div>  
</div>
</template>

<script>
import DateTime from "@/global/mixins/DateTime";

export default {

  components: {
  },

  mixins: [DateTime],

  data() {
    return {
      students: [],
      courses: [],

      student: null,
      course: null,
      booking_number: null,
      date: null,
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
      });
      this.axios.get(`/api/courses`).then(response => {
        this.courses = response.data.data;
      });
    },

    store() {
      let data = {
        courseEventId: this.course,
        studentId: this.student,
        booking: this.booking_number,
        date: this.date
      }
      this.axios.post(`/api/backoffice/import`, data).then(response => {
        this.$notify({ type: "success", text: "Daten erfasst!" });
        this.student = null;
        this.booking_number = null;
        this.date = null;
      });
    }
  
  }
}
</script>