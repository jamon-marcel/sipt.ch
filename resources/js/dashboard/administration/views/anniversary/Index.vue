<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
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
              <router-link
                :to="{ name: 'anniversary-registration-edit', params: { id: r.id } }"
                class="feather-icon"
              >
                <edit-icon size="18"></edit-icon>
              </router-link>
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

export default {

  components: {
    PlusIcon,
    DownloadIcon,
    Trash2Icon,
    EditIcon,
  },

  mixins: [Helpers, DateTime, ErrorHandling],

  data() {
    return {
      isFetched: false,
      isLoading: false,
      registrations: [],
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
  },
};
</script>
