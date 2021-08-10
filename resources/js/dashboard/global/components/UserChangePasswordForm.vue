<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  <form @submit.prevent="submit">
    <header class="content-header">
      <h1>Zugangsdaten ändern</h1>
    </header>
    <div class="grid-main-sidebar">
      <div>
        <p>Geben Sie das Passwort ein. Das neue Passwort muss aus mind. 8 Zeichen bestehen:</p>
        <div :class="[this.errors.password ? 'has-error' : '', 'form-row']" style="max-width: 540px">
          <label>Neues Passwort *</label>
          <input type="text" v-model="password" @blur="changeType($event, 'password')" @focus="changeType($event, 'text')">
          <label-required />
        </div>
        <div :class="[this.errors.password_confirm ? 'has-error' : '', 'form-row']" style="max-width: 540px">
          <label>Passwort bestätigen *</label>
          <input type="text" v-model="password_confirm" @blur="changeType($event, 'password')" @focus="changeType($event, 'text')">
          <label-required />
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
</template>
<script>

// Mixins
import ErrorHandling from "@/global/mixins/ErrorHandling";

// Components
import LabelRequired from "@/global/components/ui/LabelRequired.vue";

export default {
  components: {
    LabelRequired
  },

  mixins: [ErrorHandling],

  data() {
    return {
      password: null,
      password_confirm: null,

      errors: {
        password: false,
        password_confirm: false
      },

      isLoading: false,
      isFetched: false,
    };
  },

  methods: {
    submit() {

      if (this.password == null || this.password_confirm == null) {
        this.$notify({type: "error", text: "Bitte Angaben prüfen!"});
        return false;
      }
      else if (this.password !== this.password_confirm) {
        this.$notify({type: "error", text: "Passwörter stimmen nicht überein!"});
        return false;
      }
      else if (this.password.length < 8) {
        this.$notify({type: "error", text: "Passwort muss mind. 8 Zeichen lang sein!"});
        return false;
      }

      this.isLoading = true;
      this.axios.post(`/api/user/password`, {password: this.password, password_confirm: this.password_confirm}).then(response => {
        this.$router.push({ name: "profile" });
        this.$notify({ type: "success", text: "Passwort geändert!" });
        this.isLoading = false;
      });
    },

    changeType(event, type) {
      event.target.type = type;
    },
  },
};
</script>