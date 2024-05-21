<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <header class="content-header">
      <h1>Warteschlange für Mailing <strong>{{ mailing.subject }}</strong></h1>
    </header>
    <template v-if="batches.length > 0">
      <div class="listing sb-lg" v-for="(batch, index) in batches">
        <div class="flex items-center justify-between sa-sm">
          <div>
            <h2 class="sb-none sa-none">
              Versand vom {{ batch.created_at }}
            </h2>
            <span class="bubble bubble-mailing" v-for="(list, index) in batch.mailinglist">
              {{ list.short_description }}
            </span>
          </div>
          <div v-if="batch.processed == 0">
            <a 
              href="" 
              class="btn-tertiary is-tiny has-icon"
              @click.prevent="destroyBatch(batch.id)">
              <trash2-icon size="16"></trash2-icon>
              <span>Löschen</span>
            </a>
          </div>
          </div>
        <div
          class="listing__item is-narrow"
          v-for="item in batch.items"
          :key="item.id"
        >
          <div class="listing__item-body">
            <div class="display: flex; align-items: center;" v-if="item.subscriber">
              {{ item.subscriber.email }}
              <span class="bubble bubble-success" v-if="item.processed">Versendet</span>
            </div>
          </div>
          <list-actions 
            :id="item.id" 
            :record="item"
            :hasDestroy="item.processed ? false : true"
            :hasEdit="false"
            :hasToggle="false">
          </list-actions>
        </div>
      </div>
    </template>
    <template v-else>
      <p class="no-records">Es sind noch keine Elemente vorhanden...</p>
    </template>
  </div>
  <footer class="module-footer">
    <div>
      <router-link :to="{ name: 'mailings' }" class="btn-secondary">
        <span>Zurück</span>
      </router-link>
    </div>
  </footer>
</div>
</template>
<script>
// Icons
import { Trash2Icon } from 'vue-feather-icons';

// Components
import ListActions from "@/global/components/ui/ListActions.vue";

export default {

components: {
  ListActions,
  Trash2Icon,
},

data() {
  return {
    isLoading: false,
    isFetched: false,
    mailing: {},
    batches: [],
  };
},

created() {
  this.fetch();
},

methods: {

  fetch() {
    this.isLoading = true;
    this.axios.get(`/api/mailingqueue/${this.$route.params.id}`).then(response => {
      this.mailing = response.data.mailing;
      this.batches = response.data.batches;
      this.isFetched = true;
      this.isLoading = false;
    });
  },

  destroy(id, event) {
    if (confirm("Bitte löschen bestätigen!")) {
      let uri = `/api/mailingqueue/entry/${id}`;
      this.isLoading = true;
      this.axios.delete(uri).then(response => {
        this.fetch();
        this.isLoading = false;
      });
    }
  },

  destroyBatch(batchId) {
    if (confirm("Bitte löschen bestätigen!")) {
      let uri = `/api/mailingqueue/batch/${batchId}`;
      this.isLoading = true;
      this.axios.delete(uri).then(response => {
        this.fetch();
        this.isLoading = false;
      });
    }
  },

},
}
</script>