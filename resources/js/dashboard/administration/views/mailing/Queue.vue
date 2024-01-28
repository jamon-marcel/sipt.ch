<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <header class="content-header">
      <h1>Warteschlange für Mailing <strong>{{ mailing.subject }}</strong></h1>
    </header>
    <div class="listing sb-lg" v-for="(queue_item, index) in queue">
      <div class="flex justify-between items-end sa-sm">
        <div>
          <h2 class="sb-none sa-none">
            Batch vom {{ queue_item.date_time }}
          </h2>
          <span class="bubble bubble-mailing" v-for="(list, index) in queue_item.mailinglists">
            {{ list }}
          </span>
        </div>
        <a 
          href="" 
          class="feather-icon feather-icon--prepend" 
          style="margin-right: 7px"
          @click.prevent="destroyBatch(queue_item.batch_id)">
          <trash2-icon size="18"></trash2-icon>
          <span>Batch löschen</span>
        </a>
      </div>
      <div
        class="listing__item is-narrow"
        v-for="item in queue_item.items"
        :key="item.id"
      >
        <div class="listing__item-body">
          <div class="display: flex; align-items: center;">
            {{ item.email }}
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
    queue: [],
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
      this.queue = response.data.queue;
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