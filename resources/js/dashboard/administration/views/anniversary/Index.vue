<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <div v-if="hasOverlay">
      <cost-form :subscriber="registration" @save="saveAmount" @close="hideOverlay"></cost-form>
    </div>
    <div :class="isFetched ? 'is-loaded' : 'is-loading'">
      <header class="content-header">
        <h1>20 Jahre SIPT – Fachtagung</h1>
      </header>
      <div class="sa-xs"><strong>{{registrations.length}}</strong> Anmeldungen</div>
      <div class="listing" v-if="registrations.length">
        <div
          class="listing__item"
          v-for="r in registrations"
          :key="r.id"
        >
          <div class="listing__item-body">
            {{ r.firstname }} {{ r.name }}
            <separator/>
            {{ r.city }}
            <separator/>
            {{ r.email }}
            <separator/>
            {{ ticketLabel(r.ticket_type) }}
            <span v-if="r.is_early_bird" class="bubble-success">
              Frühbucher
            </span>
          </div>
          <div class="listing__item-action">
            <div>
              <a
                href="javascript:;"
                class="feather-icon"
                @click.prevent="showOverlay(r.id)"
              >
                <edit-icon size="18"></edit-icon>
              </a>
            </div>
            <div>
              <a
                href="javascript:;"
                class="feather-icon"
                @click.prevent="destroy(r.id)"
              >
                <trash2-icon size="18"></trash2-icon>
              </a>
            </div>
          </div>
        </div>
      </div>
      <footer class="module-footer">
        <div class="flex-sb flex-sb">
          <div>
            <a :href="'/download/20-jahre-sipt/teilnehmerliste?v=' + randomString()" class="btn-primary has-icon" target="_blank">
              <download-icon size="16"></download-icon>
              <span>Teilnehmerliste (PDF)</span>
            </a>
            <a :href="'/export/20-jahre-sipt/teilnehmerliste?v=' + randomString()" class="btn-primary has-icon" target="_blank">
              <download-icon size="16"></download-icon>
              <span>Teilnehmerliste (XLS)</span>
            </a>
          </div>
          <router-link :to="{ name: 'anniversary-registration-create' }" class="btn-secondary has-icon">
            <plus-icon size="16"></plus-icon>
            <span>Hinzufügen</span>
          </router-link>
        </div>
      </footer>
    </div>
  </div>
</template>
<script>

// Icons
import { PlusIcon, DownloadIcon, Trash2Icon, EditIcon } from 'vue-feather-icons';

// Mixins
import Helpers from "@/global/mixins/Helpers";
import DateTime from "@/global/mixins/DateTime";
import ErrorHandling from "@/global/mixins/ErrorHandling";

// Components
import CostForm from "@/administration/views/backoffice/components/CostForm.vue";

export default {

  components: {
    PlusIcon,
    DownloadIcon,
    Trash2Icon,
    EditIcon,
    CostForm
  },

  mixins: [Helpers, DateTime, ErrorHandling],

  data() {
    return {
      isFetched: false,
      isLoading: false,
      hasOverlay: false,
      registrations: [],
      registration: null,
    };
  },

  created() {
    this.fetch();
  },

  methods: {
    fetch() {
      this.isLoading = true;
      this.axios.get(`/api/anniversary/registrations`).then(response => {
        this.registrations = response.data.data;
        this.isFetched = true;
        this.isLoading = false;
      });
    },

    ticketLabel(ticketType) {
      const labels = {
        'both_days': 'Beide Tage',
        'friday_only': 'Nur Freitag',
        'saturday_only': 'Nur Samstag',
      };
      return labels[ticketType] || ticketType;
    },

    destroy(id) {
      if (confirm("Bitte löschen bestätigen!")) {
        this.isLoading = true;
        let uri = `/api/anniversary/${id}`;
        this.axios.delete(uri).then(response => {
          this.fetch();
          this.isLoading = false;
        });
      }
    },

    saveAmount(registration, amount) {
      let data = { 'cost': amount };
      let uri = `/api/anniversary/${registration}`;
      this.isLoading = true;
      this.axios.put(uri, data).then(response => {
        const idx = this.registrations.findIndex(x => x.id === registration);
        this.registrations[idx].cost = parseFloat(amount);
        this.hideOverlay();
        this.isLoading = false;
        this.$notify({ type: "success", text: "Betrag geändert!" });
      });
    },

    showOverlay(registration) {
      this.hasOverlay = true;
      this.registration = registration;
    },

    hideOverlay() {
      this.hasOverlay = false;
      this.registration = null;
    },
  },
};
</script>
