<template>
  <div class="overlay is-visible">
    <div class="overlay__inner">
      <div>
        <a href @click.prevent="toggleOverlay()" class="feather-icon">
          <x-icon size="24"></x-icon>
        </a>
        <div :class="[this.errors.date ? 'has-error' : '', 'form-row']">
          <label>Datum *</label>
          <datepicker v-model="event_date.date" :language="de" :format="dateFormat"></datepicker>
        </div>
        <div :class="[this.errors.timeStart ? 'has-error' : '', 'form-row']">
          <label>Start *</label>
          <input
            type="text"
            placeholder="z.B. 10.00"
            v-model="event_date.timeStart"
            v-cleave="{time: true, timePattern: ['h', 'm'], delimiter: '.'}">
        </div>
        <div :class="[this.errors.timeEnd ? 'has-error' : '', 'form-row']">
          <label>Ende *</label>
          <input
            type="text"
            placeholder="z.B. 12.00"
            v-model="event_date.timeEnd"
            v-cleave="{time: true, timePattern: ['h', 'm'], delimiter: '.'}">
        </div>
        <div :class="[this.errors.tutor_id ? 'has-error' : '', 'form-row']">
          <tutors
            v-bind:tutor_id.sync="event_date.tutor_id"
            :label="'Dozent'"
            :required="true"
            :model="event_date.tutor_id"
            :name="'tutor_id'"
          ></tutors>
        </div>
        <button class="btn-primary" @click.prevent="store()">Speichern</button>
      </div>
    </div>
  </div>
</template>
<script>
// Icons
import { XIcon } from "vue-feather-icons";

// Datepicker
import Datepicker from "vuejs-datepicker";
import { de } from "vuejs-datepicker/dist/locale";

// Tutors
import Tutors from "@/administration/components/Tutors.vue";

// Mixins
import DateTime from "@/global/mixins/DateTime";

export default {
  components: {
    XIcon,
    Tutors,
    Datepicker,
  },

  mixins: [DateTime],

  data() {
    return {
      // Model
      event_date: {
        date: null,
        timeStart: null,
        timeEnd: null,
        tutor_id: null
      },

      // Datepicker language
      de: de,

      // Errors
      errors: {
        date: false,
        timeStart: false,
        timeEnd: false,
        tutor_id: false
      }
    };
  },

  methods: {

    validate() {
      if (
        this.event_date.date &&
        this.event_date.timeStart &&
        this.event_date.timeEnd &&
        this.event_date.tutor_id != null
      ) {
        return true;
      }

      if (!this.event_date.date) this.errors.date = true;
      if (!this.event_date.timeStart) this.errors.timeStart = true;
      if (!this.event_date.timeEnd) this.errors.timeEnd = true;
      if (this.event_date.tutor_id == null) this.errors.tutor_id = true;
      return false;
    },

    store() {
      if (!this.validate()) {
        this.$notify({
          type: "error",
          text: "Bitte alle mit * markierten Felder prüfen!"
        });
        return false;
      }

      this.$parent.storeEventDate({
        id: null,
        date: this.dateFormat(this.event_date.date),
        timeStart: this.timeFormat(this.event_date.timeStart),
        timeEnd: this.timeFormat(this.event_date.timeEnd),
        tutor_id: this.event_date.tutor_id
      });
      
      this.$parent.toggleOverlay();
    },

    toggleOverlay() {
      this.$parent.toggleOverlay();
    },
  }
};
</script>

<style>
</style>
