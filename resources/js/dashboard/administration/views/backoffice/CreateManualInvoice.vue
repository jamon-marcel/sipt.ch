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
          ]"
        ></view-selector>
      </header>
      <div class="content content--wide">

        <div class="form-row">
          <label>Rechnungsnummer</label>
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
          <label>Beschreibung</label>
          <input type="text" v-model="description" placeholder="z.B. Symposium, 10.10./11.10.2021">
        </div>
        <!-- <div class="form-row">
          <label>Vermerk</label>
          <textarea v-model="remarks"></textarea>
        </div> -->
        <div class="form-row">
          <label>Rechnung für</label>
          <div class="select-wrapper is-wide">
            <select @change="setRecipientType($event.target.value)">
              <option value="null">Bitte wählen...</option>
              <option value="student">Student</option>
              <option value="tutor">Dozent</option>
              <option value="other">Andere</option>
            </select>
          </div>
        </div>
        <template v-if="isStudent">
          <div class="form-row">
            <label>Student suchen...</label>
            <input v-model="student_query" type="text" @blur="getStudent($event.target.value)">
            <label-info :text="'Nummer oder Name'"></label-info>
          </div>
          <div class="form-row">
            <label>...oder aus Liste wählen</label>
            <div class="select-wrapper is-wide">
              <select v-model="student">
                <option value="null">Bitte wählen...</option>
                <option
                  v-for="s in students"
                  :key="s.id"
                  :value="s.id"
                >{{ s.number }} - {{ s.name }} {{ s.firstname }}, {{ s.city }}</option>
              </select>
            </div>
          </div>
        </template>
        <template v-if="isTutor">
          <div class="form-row">
            <label>Dozent</label>
            <div class="select-wrapper is-wide">
              <select v-model="tutor" @change="getTutor($event.target.value)">
                <option value="null">Bitte wählen...</option>
                <option
                  v-for="t in tutors"
                  :key="t.id"
                  :value="t.id"
                >{{ t.name }} {{ t.firstname }}, {{ t.city }}</option>
              </select>
            </div>
          </div>
        </template>
        <template v-if="isOther">
          <div class="form-row">
            <label>Rechnungsadresse</label>
            <textarea v-model="recipient"></textarea>
          </div>
        </template>
      </div>
      <footer class="module-footer">
        <div class="flex-sb flex-vc">
          <div>
            <button class="btn-primary" @click.prevent="create()">Speichern</button>
            <router-link :to="{ name: 'backoffice-invoices' }" class="btn-secondary">
              <span>Zurück</span>
            </router-link>
          </div>
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
      number: null,
      date: null,
      description: null,
      amount: null,
      remarks: null,
      
      student: null,
      student_query: null,
      tutor: null,

      recipient: null,

      // Data
      students: null,
      tutors: null,

      // Recepients
      isStudent: false,
      isTutor: false,
      isOther: false,

      // States
      isLoading: false,
      isFetched: false,
      isFetchedEvents: false,

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

      let get_students_uri = this.axios.get("/api/students");
      let get_tutors_uri = this.axios.get("/api/tutors");

      this.axios.all([get_students_uri, get_tutors_uri]).then(response => {
        this.students = response[0].data.data;
        this.tutors = response[1].data.data;
        this.isLoading = false;
        this.isFetched = true;
      });
    },

    setRecipientType(value) {
      this.reset();
      switch(value) {
        case 'student':
          this.isStudent = true;
        break;
        case 'tutor':
          this.isTutor = true;
        break;
        case 'other':
          this.isOther = true;
        break;
      }
    },

    getStudent(value) {
      if (value.length == 0) return;
      let v = value.charAt(0).toUpperCase() + value.slice(1)
      const idx = this.students.findIndex(x => x.number == v || x.name.includes(v));
      if (idx > -1) {
        this.student = this.students[idx].id;
      }
    },

    getTutor(value) {
      if (value.length == 0) return;
      let v = value.charAt(0).toUpperCase() + value.slice(1)
      const idx = this.tutors.findIndex(x => x.name.includes(v));
      if (idx > -1) {
        this.tutor = this.tutors[idx].id;
      }
    },

    create() {

      if (this.student == null && this.tutor == null && this.recipient == null) {
        this.$notify({ type: "error", text: "Empfänger fehlt!" });
        return;
      }

      if (this.amount == null) {
        this.$notify({ type: "error", text: "Betrag fehlt!" });
        return;
      }
      
      let data = {
        studentId: this.student,
        tutorId: this.tutor,
        recipient: this.recipient,
        number: this.number,
        date: this.date,
        amount: this.amount,
        description: this.description,
        remarks: this.remarks,
      };

      this.isLoading = true;
      this.axios.post(`/api/backoffice/invoice/manual/store`, data).then(response => {
        this.$notify({ type: "success", text: "Daten erfasst!" });
        this.isLoading = false;
        this.file = response.data;
        this.clear();
        this.reset();
      });
    },

    clear() {
      this.number = null;
      this.date = null;
      this.amount = null;
      this.student = null;
      this.student_query = null;
      this.tutor = null;
      this.tutor_query = null;
    },

    reset() {
      this.isStudent = false;
      this.student = null;
      this.student_query = null;
      this.isTutor   = false;
      this.tutor = null;
      this.isOther   = false;
    }
  }
};
</script>
