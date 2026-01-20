<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <div :class="isFetched ? 'is-loaded' : 'is-loading'">
      <header class="content-header">
        <h1>Anmeldung hinzufügen</h1>
      </header>
      <form @submit.prevent="submit" class="form-grid">
        <div :class="[this.errors.salutation ? 'has-error' : '', 'form-row']">
          <label>Anrede *</label>
          <select v-model="registration.salutation">
            <option value="">Bitte wählen</option>
            <option value="Frau">Frau</option>
            <option value="Herr">Herr</option>
            <option value="Divers">Divers</option>
          </select>
          <label-required />
        </div>
        <div :class="[this.errors.firstname ? 'has-error' : '', 'form-row']">
          <label>Vorname *</label>
          <input type="text" v-model="registration.firstname">
          <label-required />
        </div>
        <div :class="[this.errors.name ? 'has-error' : '', 'form-row']">
          <label>Name *</label>
          <input type="text" v-model="registration.name">
          <label-required />
        </div>
        <div class="form-row">
          <label>Titel</label>
          <input type="text" v-model="registration.title">
        </div>
        <div :class="[this.errors.email ? 'has-error' : '', 'form-row']">
          <label>E-Mail *</label>
          <input type="email" v-model="registration.email">
          <label-required />
        </div>
        <div class="form-row">
          <label>Telefon</label>
          <input type="text" v-model="registration.phone">
        </div>
        <div :class="[this.errors.street ? 'has-error' : '', 'form-row']">
          <label>Strasse *</label>
          <input type="text" v-model="registration.street">
          <label-required />
        </div>
        <div :class="[this.errors.street_no ? 'has-error' : '', 'form-row']">
          <label>Hausnummer *</label>
          <input type="text" v-model="registration.street_no">
          <label-required />
        </div>
        <div :class="[this.errors.zip ? 'has-error' : '', 'form-row']">
          <label>PLZ *</label>
          <input type="text" v-model="registration.zip">
          <label-required />
        </div>
        <div :class="[this.errors.city ? 'has-error' : '', 'form-row']">
          <label>Ort *</label>
          <input type="text" v-model="registration.city">
          <label-required />
        </div>
        <div :class="[this.errors.ticket_type ? 'has-error' : '', 'form-row']">
          <label>Ticket *</label>
          <select v-model="registration.ticket_type">
            <option value="">Bitte wählen</option>
            <option value="both_days">Beide Tage (Fr + Sa)</option>
            <option value="friday_only">Nur Freitag, 21.8.26</option>
            <option value="saturday_only">Nur Samstag, 22.8.26</option>
          </select>
          <label-required />
        </div>
        <div class="form-row" v-if="showApero">
          <label>Apéro Freitag</label>
          <select v-model="registration.apero_friday">
            <option :value="1">Ja, nimmt teil</option>
            <option :value="0">Nein, nimmt nicht teil</option>
          </select>
        </div>
        <div class="form-row" v-if="showLunch">
          <label>Mittagessen Samstag</label>
          <select v-model="registration.lunch_saturday">
            <option :value="1">Ja, nimmt teil</option>
            <option :value="0">Nein, nimmt nicht teil</option>
          </select>
        </div>
        <div class="form-buttons align-end">
          <router-link :to="{ name: 'anniversary' }" class="btn-secondary">Abbrechen</router-link>
          <button type="submit" class="btn-primary">Speichern</button>
        </div>
      </form>
    </div>
  </div>
</template>
<script>

// Mixins
import ErrorHandling from "@/global/mixins/ErrorHandling";

export default {

  mixins: [ErrorHandling],

  data() {
    return {
      isFetched: true,
      isLoading: false,
      registration: {
        salutation: '',
        firstname: '',
        name: '',
        title: '',
        email: '',
        phone: '',
        street: '',
        street_no: '',
        zip: '',
        city: '',
        ticket_type: '',
        apero_friday: 0,
        lunch_saturday: 0,
      },
      errors: {
        salutation: false,
        firstname: false,
        name: false,
        email: false,
        street: false,
        street_no: false,
        zip: false,
        city: false,
        ticket_type: false,
      },
    };
  },

  computed: {
    showApero() {
      return this.registration.ticket_type === 'both_days' || this.registration.ticket_type === 'friday_only';
    },
    showLunch() {
      return this.registration.ticket_type === 'both_days' || this.registration.ticket_type === 'saturday_only';
    },
  },

  methods: {
    submit() {
      // Reset errors
      Object.keys(this.errors).forEach(key => {
        this.errors[key] = false;
      });

      // Validate required fields
      let hasErrors = false;
      const required = ['salutation', 'firstname', 'name', 'email', 'street', 'street_no', 'zip', 'city', 'ticket_type'];
      required.forEach(field => {
        if (!this.registration[field]) {
          this.errors[field] = true;
          hasErrors = true;
        }
      });

      if (hasErrors) {
        this.$notify({ type: "error", text: "Bitte alle Pflichtfelder ausfüllen!" });
        return;
      }

      this.isLoading = true;
      let uri = `/api/anniversary/register`;
      this.axios.post(uri, { registration: this.registration }).then(response => {
        this.isLoading = false;
        this.$notify({ type: "success", text: "Anmeldung gespeichert!" });
        this.$router.push({ name: 'anniversary' });
      }).catch(error => {
        this.isLoading = false;
        if (error.response && error.response.status === 500) {
          this.$notify({ type: "error", text: error.response.data.message || "Fehler beim Speichern!" });
        } else {
          this.$notify({ type: "error", text: "Fehler beim Speichern!" });
        }
      });
    },
  },
};
</script>
