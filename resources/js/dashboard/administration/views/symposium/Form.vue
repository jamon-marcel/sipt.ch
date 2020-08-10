<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <div class="form-row">
      <label>Kundennummer</label>
      <input v-model="number" type="text" @blur="getStudent($event.target.value)">
    </div>
    <div class="form-row">
      <label>Student</label>
      <div class="select-wrapper is-wide">
        <select name="student" v-model="subscriberId">
          <option value="null">Bitte wählen...</option>
          <option
            v-for="s in students"
            :key="s.id"
            :value="s.id"
          >{{ s.number }} - {{ s.name }} {{ s.firstname }}, {{ s.city }}, {{s.user.email}}</option>
        </select>
      </div>
    </div>
    <div v-if="subscriberId == null">
      <div class="form-row">
        <label>Name</label>
        <input type="text" v-model="subscriber.name">
      </div>
      <div class="form-row">
        <label>Vorname</label>
        <input type="text" v-model="subscriber.firstname">
      </div>
      <div class="form-row">
        <label>Titel</label>
        <input type="text" v-model="subscriber.title">
      </div>
      <div class="form-row">
        <label>Strasse</label>
        <input type="text" v-model="subscriber.street">
      </div>
      <div class="form-row">
        <label>Strasse Nummer</label>
        <input type="text" v-model="subscriber.street_no">
      </div>
      <div class="form-row">
        <label>PLZ</label>
        <input type="text" v-model="subscriber.zip">
      </div>
      <div class="form-row">
        <label>Ort</label>
        <input type="text" v-model="subscriber.city">
      </div>
      <div class="form-row">
        <label>Land</label>
        <input type="text" v-model="subscriber.country">
      </div>
      <div class="form-row">
        <label>Telefon P</label>
        <input type="text" v-model="subscriber.phone">
      </div>
      <div class="form-row">
        <label>Telefon G</label>
        <input type="text" v-model="subscriber.phone_business">
      </div>
      <div class="form-row">
        <label>Mobile</label>
        <input type="text" v-model="subscriber.mobile">
      </div>
      <div class="form-row">
        <label>E-Mail</label>
        <input type="text" v-model="subscriber.email">
      </div>
      <div class="form-row">
        <label>Berufsabschluss</label>
        <input type="text" v-model="subscriber.qualifications">
      </div>
    </div>
    <div class="form-row">
      <label>Buchungsnummer</label>
      <input type="text" v-model="booking_number">
    </div>
    <div class="form-row">
      <label>Datum</label>
      <input type="text" v-model="date" v-cleave="{delimiter: '.', blocks: [2, 2, 4]}">
    </div>
    <div>
      <button class="btn-primary" @click.prevent="store()">Speichern</button>
    </div>
  </div>
</template>

<script>
import ErrorHandling from "@/global/mixins/ErrorHandling";
import DateTime from "@/global/mixins/DateTime";
import Helpers from "@/global/mixins/Helpers";

export default {
  components: {},

  mixins: [DateTime, Helpers, ErrorHandling],

  data() {
    return {
      students: [],

      number: null,
      subscriberId: null,
      
      subscriber: {
        name: null,
        firstname: null,
        title: null,
        street: null,
        street_no: null,
        zip: null,
        city: null,
        country: null,
        phone: null,
        phone_business: null,
        mobile: null,
        email: null,
        qualifications: null,
      },

      booking_number: null,
      date: null,

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
    },

    store() {

      if (this.booking_number == null || this.date == null) {
        this.$notify({ type: "error", text: "Ungültige Daten!" });
        return;
      }

      let data;

      if (this.subscriberId != null) {
        data = {
          subscriberId: this.subscriberId,
          booking_number: this.booking_number,
          created_at: this.date,
        }
      }
      else {
        data = {
          subscriber: this.subscriber,
          booking_number: this.booking_number,
          created_at: this.date,
        }
      }

      this.isLoading = true;
      this.axios.post(`/api/symposium/subscribe`, data).then(response => {
        this.$notify({ type: "success", text: "Daten erfasst!" });
        this.isLoading = false;
        this.subscriberId = null;
        this.booking_number = null;
        this.subscriber.name = null;
        this.subscriber.firstname = null;
        this.subscriber.title = null;
        this.subscriber.street = null;
        this.subscriber.street_no = null;
        this.subscriber.zip = null;
        this.subscriber.city = null;
        this.subscriber.country = null;
        this.subscriber.mobile = null;
        this.subscriber.phone = null;
        this.subscriber.phone_business = null;
        this.subscriber.email = null;
        this.subscriber.qualifications = null;
        this.date = null;
        this.number = null;
      });
    },

    getStudent(value) {
      const idx = this.students.findIndex(x => x.number == value);
      this.subscriberId = null;
      if (idx != -1) {
        this.subscriberId = this.students[idx].id;
      }
    },
  }
};
</script>
