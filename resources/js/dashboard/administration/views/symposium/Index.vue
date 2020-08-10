<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <div :class="isFetched ? 'is-loaded' : 'is-loading'">
      <header class="content-header">
        <h1>Jubiläums-Fachtagung — 15 Jahre SIPT</h1>
      </header>
      <div class="sa-xs"><strong>{{subscribers.length}}</strong> TeilnehmerInnen</div>
      <div class="listing" v-if="subscribers.length">
        <div
          class="listing__item"
          v-for="s in subscribers"
          :key="s.id"
        >
          <div class="listing__item-body">
            {{ s.booking_number}}
            <separator/>
            {{s.firstname }} {{ s.name}}
            <separator/>
            {{ s.city }}
            <separator/>
            {{ s.email }}
            <separator/>
            {{dateFormat(s.created_at, 'DD.MM.YYYY')}}
          </div>
          <div class="listing__item-action">
            <div>
              <a
                href="javascript:;"
                class="feather-icon"
                @click.prevent="destroy(s.id)"
              >
                <trash2-icon size="18"></trash2-icon>
              </a>
            </div>
          </div>
        </div>
      </div>
      <footer class="module-footer">
        <div class="flex-sb flex-vc">
          <a :href="'/download/fachtagung/teilnehmerliste?v=' + randomString()" class="btn-primary has-icon" target="_blank">
            <download-icon size="16"></download-icon>
            <span>Teilnehmerliste</span>
          </a>
          <router-link :to="{ name: 'symposium-subscriber-create' }" class="btn-secondary has-icon">
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
import { PlusIcon, DownloadIcon, Trash2Icon } from 'vue-feather-icons';

// Mixins
import Helpers from "@/global/mixins/Helpers";
import DateTime from "@/global/mixins/DateTime";
import ErrorHandling from "@/global/mixins/ErrorHandling";

export default {

  components: {
    PlusIcon,
    DownloadIcon,
    Trash2Icon
  },

  mixins: [Helpers, DateTime, ErrorHandling],

  data() {
    return {
      isFetched: false,
      isLoading: false,
      search: "",
      subscribers: []
    };
  },

  created() {
    this.fetch();
  },

  methods: {
    fetch() {
      this.isLoading = true;
      this.axios.get(`/api/symposium/subscribers`).then(response => {
        this.subscribers = response.data.data;
        this.isFetched = true;
        this.isLoading = false;
      });
    },

    destroy(id) {
      if (confirm("Bitte löschen bestätigen!")) {
        this.isLoading = true;
        let uri = `/api/symposium/${id}`;
        this.axios.delete(uri).then(response => {
          this.fetch();
          this.isLoading = false;
        });
      }
    }
  },
};
</script>