<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <div :class="isFetched ? 'is-loaded' : 'is-loading'">
      <header class="content-header flex-sb flex-vc">
        <h1>Rechnung bearbeiten</h1>
        <view-selector
          :items="[
            {route: '/administration/backoffice/modules', label: 'Module'},
            {route: '/administration/backoffice/invoices', label: 'Rechnungen'},
          ]"
        ></view-selector>
      </header>
      <div class="content content--wide">
        <div class="form-row">
          <label>Rechnung wählen</label>
          <div class="select-wrapper is-wide">
            <select @change="getInvoice($event.target.value)">
              <option value="">Bitte wählen...</option>
              <option
                v-for="i in invoices"
                :key="i.id"
                :value="i.id"
              >{{ i.number }} <em v-if="i.student">-  {{ i.student.firstname }} {{ i.student.name }}, {{ i.student.city }}</em>
              </option>
            </select>
          </div>
        </div>
        <div class="form-row">
          <label>Datum</label>
          <input type="text" v-model="date" v-if="date">
          <input type="text" v-model="date" v-cleave="{delimiter: '.', blocks: [2, 2, 4]}" v-else>
          <label-info :text="'Leer lassen für heutiges Datum'"></label-info>
        </div>
        <div class="form-row">
          <label>Betrag</label>
          <input type="text" v-model="amount" placeholder="z.B. 450">
        </div>
        <div class="form-row">
          <label>Rechnungsadresse</label>
          <textarea v-model="address"></textarea>
        </div>
      </div>
      <footer class="module-footer">
        <div class="flex-sb flex-vc">
          <div>
            <button class="btn-primary" @click.prevent="submit()">Speichern</button>
            <router-link :to="{ name: 'backoffice-invoices' }" class="btn-secondary">
              <span>Zurück</span>
            </router-link>
          </div>
          <div v-if="file">
            <a :href="'/storage/invoices/' + file" target="_blank" class="btn-primary has-icon">
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
import { FilePlusIcon, DownloadIcon} from "vue-feather-icons";

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
  },

  mixins: [DateTime, Helpers],

  data() {
    return {
      date: null,
      amount: null,
      address: null,
      studentId: null,
      courseEventId: null,

      invoice: null,
      invoices: null,

      // States
      isLoading: false,
      isFetched: false,

      // File uri
      file: null,
    };
  },

  created() {
    this.fetch();
  },

  methods: {

    fetch() {
      this.isLoading = true;
      this.axios.get(`/api/backoffice/invoices`).then(response => {
        this.invoices = response.data.data;
        this.isLoading = false;
        this.isFetched = true;
      });
    },

    getInvoice(value) {
      if (value.length == 0) return;
      const idx = this.invoices.findIndex(x => x.id == value);
      this.invoice = this.invoices[idx]; 
      this.amount = this.invoice.amount;
      this.date = this.invoice.date;
      this.courseEventId = this.invoice.course_event_id;

      console.log(this.invoice);
      
      if (this.invoice.student) {
        this.studentId = this.invoice.student_id;
      }

      if (this.invoice.student) {
        if (this.invoice.student.has_alt_address) {
          let address = '';

          if (this.invoice.student.alt_company) {
            address += `${this.invoice.student.alt_company}\n`;
          }
          if (this.invoice.student.alt_name) {
            address += `${this.invoice.student.alt_name}\n`;
          }
          if (this.invoice.student.alt_street) {
            address += `${this.invoice.student.alt_street} ${this.invoice.student.alt_street_no}\n`;
          }
          if (this.invoice.student.alt_zip || this.invoice.student.alt_city) {
            address += `${this.invoice.student.alt_zip} ${this.invoice.student.city}`;
          }
          this.address = address;
        }
      }
    },

    submit() {

      if (this.amount == null) {
        this.$notify({ type: "error", text: "Betrag fehlt!" });
        return;
      }

      if (this.date == null) {
        this.$notify({ type: "error", text: "Datum fehlt!" });
        return;
      }
      
      let data = {
        studentId: this.studentId,
        invoiceId: this.invoice.id,
        invoiceNumber: this.invoice.number,
        courseEventId: this.courseEventId,
        date: this.date,
        amount: this.amount,
        address: this.address,
      };

      this.isLoading = true;
      this.axios.post(`/api/backoffice/invoice/edit`, data).then(response => {
        this.$notify({ type: "success", text: "Rechnung gespeichert!" });
        this.isLoading = false;
        this.file = response.data;
        this.clear();
      });
    },

    clear() {
      this.date = null;
      this.amount = null;
      this.address = null;
      this.studentId = null;
      this.invoiceId = null;
      this.invoice = null;
    },
  }
};
</script>
