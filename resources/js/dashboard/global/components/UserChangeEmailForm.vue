<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  <form @submit.prevent="submit">
    <header class="content-header">
      <h1>Zugangsdaten ändern</h1>
    </header>
    <div class="grid-main-sidebar">
      <div>
        <p>Geben Sie die gewünschte neue E-Mail Adresse ein. Sie erhalten danach eine E-Mail mit einem Link für die Bestätigung der neuen Adresse.</p>
        <div :class="[this.errors.email ? 'has-error' : '', 'form-row']">
          <label>Neue E-Mail *</label>
          <input type="text" v-model="email">
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
      email: null,

      errors: {
        email: false,
      },

      isLoading: false,
      isFetched: false,
    };
  },

  methods: {
    submit() {
      this.isLoading = true;
      this.axios.post(`/api/user/email`, {email: this.email}).then(response => {
        this.$router.push({ name: "profile" });
        this.$notify({ type: "success", text: "E-Mail Adresse geändert!" });
        this.isLoading = false;
      });
    },
  },
};
</script>