<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  <form @submit.prevent="submit">
    <header class="content-header">
      <h1>{{title}}</h1>
    </header>
    <div class="grid-main-sidebar">
      <div>
        <div class="form-row">
          <label>Anrede</label>
          <input type="text" v-model="address.gender">
        </div>
        <div :class="[this.errors.firstname ? 'has-error' : '', 'form-row']">
          <label>Vorname *</label>
          <input type="text" v-model="address.firstname">
          <label-required />
        </div>
        <div :class="[this.errors.name ? 'has-error' : '', 'form-row']">
          <label>Name *</label>
          <input type="text" v-model="address.name">
          <label-required />
        </div>
        <div class="form-row">
          <label>Firma</label>
          <input type="text" v-model="address.company">
        </div>
        <div class="form-row">
          <label>Abteilung</label>
          <input type="text" v-model="address.department">
        </div>
        <div class="form-row">
          <label>Titel</label>
          <input type="text" v-model="address.title">
        </div>
        <div class="form-row">
          <label>Funktion</label>
          <input type="text" v-model="address.role">
        </div>
        <div class="form-row">
          <label>E-Mail</label>
          <input type="text" v-model="address.email">
        </div>
        <div class="form-row">
          <label>Telefon</label>
          <input type="text" v-model="address.phone">
        </div>
        <div class="form-row">
          <label>Mobile</label>
          <input type="text" v-model="address.mobile">
        </div>
        <div class="form-row">
          <div class="grid grid-3-1">
            <div>
              <label>Strasse</label>
              <input type="text" v-model="address.street">
            </div>
            <div>
              <label>Nr.</label>
              <input type="text" v-model="address.street_no">
            </div>
          </div>
        </div>
        <div class="form-row">
          <div>
            <label>Adresszusatz</label>
            <input type="text" v-model="address.address_extra">
          </div>
        </div>
        <div class="form-row">
          <div class="grid grid-1-1">
            <div>
              <label>PLZ</label>
              <input type="text" v-model="address.zip">
            </div>
            <div>
              <label>Ort</label>
              <input type="text" v-model="address.city">
            </div>
          </div>
        </div>
        <div class="form-row">
          <div>
            <label>Land</label>
            <input type="text" v-model="address.country">
          </div>
        </div>
      </div>
    </div>
    <footer class="module-footer">
      <div>
        <button type="submit" class="btn-primary">Speichern</button>
        <router-link :to="{ name: 'vip-addresses' }" class="btn-secondary">
          <span>Zurück</span>
        </router-link>
      </div>
    </footer>
  </form>
</div>
</template>
<script>

// Icons
import { ArrowLeftIcon } from 'vue-feather-icons';

// Mixins
import ErrorHandling from "@/global/mixins/ErrorHandling";

// Components
import RadioButton from "@/global/components/ui/RadioButton.vue";
import LabelRequired from "@/global/components/ui/LabelRequired.vue";

export default {
  components: {
    ArrowLeftIcon,
    RadioButton,
    LabelRequired,
  },

  mixins: [ErrorHandling],

  props: {
    type: String
  },

  data() {
    return {
      
      // Model
      address: {
        gender: null,
        firstname: null,
        name: null,
        title: null,
        role: null,
        company: null,
        department: null,
        street: null,
        street_no: null,
        address_extra: null,
        zip: null,
        city: null,
        country: null,
        phone: null,
        mobile: null,
      },

      // Validation
      errors: {
        firstname: false,
        name: false,
      },

      // Loading states
      isFetched: true,
      isLoading: false,
    };
  },

  created() {
    if (this.$props.type == "edit") {
      this.isFetched = false;
      let uri = `/api/vip-address/${this.$route.params.id}`;
      this.axios.get(uri).then(response => {
        this.address = response.data;
        this.isFetched = true;
      });
    }
  },

  methods: {

    // Submit form
    submit() {
      if (this.$props.type == "edit") {
        this.update();
      }

      if (this.$props.type == "create") {
        this.store();
      }
    },

    store() {
      this.isLoading = true;
      this.axios.post('/api/vip-address', this.address).then(response => {
        this.$router.push({ name: "vip-addresses" });
        this.$notify({ type: "success", text: "Adresse erfasst!" });
        this.isLoading = false;
      });
    },

    update() {
      let uri = `/api/vip-address/${this.$route.params.id}`;
      this.isLoading = true;
      this.axios.put(uri, this.address).then(response => {
        this.$router.push({ name: "vip-addresses" });
        this.$notify({ type: "success", text: "Änderungen gespeichert!" });
        this.isLoading = false;
      });
    },
  },

  computed: {
    title: function() {
      return this.$props.type == "edit" 
        ? "Adresse bearbeiten" 
        : "Adresse hinzufügen";
    }
  }
};
</script>
