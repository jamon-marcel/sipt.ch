<template>
  <div class="overlay is-visible">
    <div class="overlay__inner">
      <div>
        <a href @click.prevent="toggleOverlay()" class="feather-icon">
          <x-icon size="24"></x-icon>
        </a>
        <h2>Zeitraum</h2>
        <div class="form-row is-sm">
          <label class="is-sm">Von</label>
          <datepicker v-model="dateFrom" :language="de" :format="dateFormat" :typeable="true"></datepicker>
        </div>
        <div class="form-row">
          <label class="is-sm">Bis</label>
          <datepicker v-model="dateTo" :language="de" :format="dateFormat" :typeable="true"></datepicker>
        </div>
        <a :href="'/download/modulliste?v=' + randomString() + range+''" class="btn-primary has-icon" target="_blank">
          <download-icon size="16"></download-icon>
          <span>Download {{ rangeString }}</span>
        </a>
      </div>
    </div>
  </div>
</template>
<script>
// Icons
import { XIcon, DownloadIcon } from "vue-feather-icons";

// Datepicker
import Datepicker from "vuejs-datepicker";
import { de } from "vuejs-datepicker/dist/locale";

// Mixins
import DateTime from "@/global/mixins/DateTime";
import Helpers from "@/global/mixins/Helpers";

export default {
  components: {
    XIcon,
    DownloadIcon,
    Datepicker
  },

  mixins: [DateTime, Helpers],

  data() {
    return {
      dateFrom: null,
      dateTo: null,
      
      // Datepicker language
      de: de,
    };
  },

  methods: {
    toggleOverlay() {
      this.$parent.toggleOverlay();
    },
  },

  computed: {
    range: function() {
      if (this.dateFrom !== null && this.dateTo !== null) {
        return '&from='+this.dateFormat(this.dateFrom)+'&to='+ this.dateFormat(this.dateTo);
      }
      if (this.dateFrom !== null) {
        return '&from='+this.dateFormat(this.dateFrom)
      }
      if (this.dateTo !== null) {
        return '&to='+ this.dateFormat(this.dateTo);
      }
      return '';
    },
    
    rangeString: function() {
      if (this.dateFrom !== null && this.dateTo !== null) {
        return this.dateFormat(this.dateFrom) + ' – ' + this.dateFormat(this.dateTo);
      }
      if (this.dateFrom !== null) {
        return 'ab ' + this.dateFormat(this.dateFrom);
      }
      if (this.dateTo !== null) {
        return 'bis ' + this.dateFormat(this.dateTo);
      }
      return '(aktuelle Liste)';
    }
  }
};
</script>