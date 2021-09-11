<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  <div class="overlay is-visible" v-if="isFetched">
    <div class="overlay__inner is-wide">
      <div>
        <a href @click.prevent="hideAddStudentForm()" class="feather-icon">
          <x-icon size="24"></x-icon>
        </a>
        <div class="sa-xs">
          <h2>Teilnehmerin hinzufügen</h2>
          <div>Fügen Sie eine Teilnehmerin nachträglich hinzu. Es wird <strong>keine Kurseinladung</strong> und <strong>keine Anmeldebestätigung</strong> versendet.</div>
        </div>
        <div class="form-row">
          <label>Teilnehmerin auswählen:</label>
          <div class="select-wrapper is-wide">
            <select name="student" v-model="student">
              <option value="null">Bitte wählen...</option>
              <option
                v-for="s in students"
                :key="s.id"
                :value="s.id"
              >{{ s.name }} {{ s.firstname }}, {{ s.city }}</option>
            </select>
          </div>
          <label-required />
        </div>

        <div class="form-row">
          <radio-button
            :label="'Soll für diese Buchung eine Rechnung erstellt werden?'"
            :labelClass="''"
            v-bind:has_billing.sync="has_billing"
            :model="has_billing"
            :name="'has_billing'"
          ></radio-button>
        </div>
        <div class="sb-sm flex-vc">
          <button class="btn-primary" @click.prevent="store()">Speichern</button>
          <a href="javascript:;" class="btn-close" @click.prevent="hideAddStudentForm()">Abbrechen</a>
        </div>
      </div>
    </div>
  </div>
</div>
</template>
<script>

// Components
import LabelRequired from "@/global/components/ui/LabelRequired.vue";
import RadioButton from "@/global/components/ui/RadioButton.vue";

// Icons
import { XIcon } from "vue-feather-icons";

export default {
  components: {
    XIcon,
    RadioButton,
    LabelRequired
  },

  data() {
    return {
      students: null,
      student: null,
      has_billing: 1,
      isFetched: false,
      isLoading: false
    }
  },

  created() {
    this.fetch();
  },

  methods: {

    fetch() {
      this.isLoading = true;
      this.axios.get(`/api/students/1`).then(response => {
        this.students = response.data.data;
        this.isFetched = true;
        this.isLoading = false;
      });
    },

    store() {
      if (this.student == null || this.student == 'null') {
        this.$notify({
          type: "error",
          text: "Bitte Teilnehmerin auswählen!"
        });
        return false;
      }
      this.$parent.storeStudent(this.student, this.has_billing);
    },

    hideAddStudentForm() {
      this.$parent.hideAddStudentForm();
    },
  }
};
</script>