<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  <div v-if="isFetched">
    <form @submit.prevent="submit">
      <header class="content-header">
        <h1>Profil bearbeiten</h1>
      </header>
      <div class="grid-main-sidebar">
        <div>
          <div :class="[this.errors.firstname ? 'has-error' : '', 'form-row']">
            <label>Vorname *</label>
            <input type="text" v-model="student.firstname">
            <label-required />
          </div>
          <div :class="[this.errors.name ? 'has-error' : '', 'form-row']">
            <label>Name *</label>
            <input type="text" v-model="student.name">
            <label-required />
          </div>
          <div class="form-row">
            <div class="grid grid-3-1">
              <div :class="[this.errors.street ? 'has-error' : '', 'form-row-grid']">
                <label>Strasse *</label>
                <input type="text" v-model="student.street">
                <label-required />
              </div>
              <div class="form-row-grid">
                <label>Nr.</label>
                <input type="text" v-model="student.street_no">
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="grid grid-1-1-1">
              <div :class="[this.errors.zip ? 'has-error' : '', 'form-row-grid']">
                <label>PLZ *</label>
                <input type="text" v-model="student.zip">
                <label-required />
              </div>
              <div :class="[this.errors.city ? 'has-error' : '', 'form-row-grid']">
                <label>Ort *</label>
                <input type="text" v-model="student.city">
                <label-required />
              </div>
              <div :class="[this.errors.country ? 'has-error' : '', 'form-row-grid']">
                <label>Land *</label>
                <input type="text" v-model="student.country">
                <label-required />
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="grid grid-1-1-1">
              <div :class="[this.errors.phone ? 'has-error' : '', 'form-row-grid']">
                <label>Telefon</label>
                <input type="text" v-model="student.phone">
                <label-required />
              </div>
              <div class="form-row-grid">
                <label>Telefon Geschäft</label>
                <input type="text" v-model="student.phone_business">
              </div>
              <div class="form-row-grid">
                <label>Mobile</label>
                <input type="text" v-model="student.mobile">
              </div>
            </div>
          </div>
          <div class="form-row">
            <label>Titel</label>
            <input type="text" v-model="student.title">
          </div>
          <div class="form-row">
            <label>Berufsabschluss</label>
            <input type="text" v-model="student.qualifications">
          </div>
          <div class="form-row">
            <a href="" @click.prevent="toggleAltAddress()" class="feather-icon feather-icon--prepend">
              <toggle-left-icon size="18" v-if="!student.has_alt_address"></toggle-left-icon>
              <toggle-right-icon size="18" v-if="student.has_alt_address"></toggle-right-icon>
              <span>Abweichende Rechnungsadresse</span>
            </a>
          </div>
          <div class="form-row">
            <div v-if="student.has_alt_address">
              <div :class="[this.errors.alt_company ? 'has-error' : '', 'form-row']">
                <label>Firma</label>
                <input type="text" v-model="student.alt_company">
                <label-required />
              </div>
              <div :class="[this.errors.alt_name ? 'has-error' : '', 'form-row']">
                <label>Name</label>
                <input type="text" v-model="student.alt_name">
                <label-required />
              </div>
              <div class="form-row">
                <div class="grid grid-3-1">
                  <div :class="[this.errors.alt_street ? 'has-error' : '', 'form-row-grid']">
                    <label>Strasse</label>
                    <input type="text" v-model="student.alt_street">
                    <label-required />
                  </div>
                  <div :class="[this.errors.alt_street_no ? 'has-error' : '', 'form-row-grid']">
                    <label>Nr.</label>
                    <input type="text" v-model="student.alt_street_no">
                    <label-required />
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="grid grid-1-3">
                  <div :class="[this.errors.alt_zip ? 'has-error' : '', 'form-row-grid']">
                    <label>PLZ</label>
                    <input type="text" v-model="student.alt_zip">
                    <label-required />
                  </div>
                  <div :class="[this.errors.alt_city ? 'has-error' : '', 'form-row-grid']">
                    <label>Ort</label>
                    <input type="text" v-model="student.alt_city">
                    <label-required />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="grid-column-sidebar">
          <div>
            <template v-if="isFetched">
              <div class="form-row is-sm">
                <radio-button
                  :label="'Bestätigung Ausweisung Kursdauer?'"
                  v-bind:needs_hours_confirmation.sync="student.needs_hours_confirmation"
                  :model="student.needs_hours_confirmation"
                  :name="'needs_hours_confirmation'"
                ></radio-button>
              </div>

              <mailinglists :email="student.user.email" />

              <div class="form-row is-sm is-last">
                <radio-button
                  :label="'Aufbautipp / Newsletter erhalten?'"
                  v-bind:is_newsletter_subscriber.sync="student.user.is_newsletter_subscriber"
                  :model="student.user.is_newsletter_subscriber"
                  :name="'is_newsletter_subscriber'"
                ></radio-button>
              </div>
            </template>
          </div>
        </div>
      </div>
      <footer class="module-footer">
        <div>
          <button type="submit" class="btn-primary">Speichern</button>
          <router-link :to="{ name: 'profile' }" class="btn-secondary">
            <span>Zurück</span>
          </router-link>
        </div>
      </footer>
    </form>
  </div>
</div>

</template>
<script>

// Icons
import { ToggleLeftIcon, ToggleRightIcon } from 'vue-feather-icons';

// Mixins
import ErrorHandling from "@/global/mixins/ErrorHandling";

// Components
import RadioButton from "@/global/components/ui/RadioButton.vue";
import LabelRequired from "@/global/components/ui/LabelRequired.vue";
import Mailinglists from "@/global/components/Mailinglists.vue";

export default {
  components: {
    ToggleLeftIcon,
    ToggleRightIcon,
    RadioButton,
    LabelRequired,
    Mailinglists
  },

  mixins: [ErrorHandling],

  data() {
    return {
      student: {
        user: {
          email: null,
          is_newsletter_subscriber: 0,
        },
        has_alt_address: false,
        mailinglists: []
      },

      errors: {
        firstname: false,
        name: false,
        street: false,
        zip: false,
        city: false,
        phone: false,
        country: false,

        alt_company: false,
        alt_name: false,
        alt_street: false,
        alt_street_no: false,
        alt_zip: false,
        alt_city: false,
      },

      isFetched: true,
      isLoading: false,

    };
  },

  created() {
    this.isFetched = false;
    let uri = `/api/student/${this.$route.params.id}`;
    this.axios.get(uri).then(response => {
      this.student = response.data;
      this.isFetched = true;
    });
  },

  methods: {

    submit() {
      let uri = `/api/student/${this.$route.params.id}`;
      this.isLoading = true;
      this.axios.put(uri, this.student).then(response => {
        this.$router.push({ name: "profile" });
        this.$notify({ type: "success", text: "Änderungen gespeichert!" });
        this.isLoading = false;
      });
    },

    toggleAltAddress() {
      this.student.has_alt_address = this.student.has_alt_address ? false : true;
    }
  },
};
</script>