<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <header class="content-header">
      <h1>Warteschlange für Mailing <strong>{{ mailing.subject }}</strong></h1>
    </header>
    <div class="listing sb-md" v-for="(list, index) in list_items">
      <div class="flex justify-between items-center sa-xs">
        <h2 class="sb-none">{{ list.description }}</h2>
        <a 
          href="" 
          class="feather-icon" 
          style="margin-right: 7px"
          @click.prevent="destroyList(mailing.id, list.id)">
          <trash2-icon size="18"></trash2-icon>
        </a>
      </div>
      <div
        class="listing__item is-narrow"
        v-for="m in list.items"
        :key="m.id"
      >
        <div class="listing__item-body">
          <div class="display: flex; align-items: center;">
            {{ m.email }}
            <span class="bubble bubble-success" v-if="m.processed">Versendet</span>
          </div>
        </div>
        <list-actions 
          :id="m.id" 
          :record="m"
          :hasDestroy="m.processed ? false : true"
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
    list_items: [],
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
      this.list_items = response.data.list_items;
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

  destroyList(mailingId, listId) {
    if (confirm("Bitte löschen bestätigen!")) {
      let uri = `/api/mailingqueue/list/${mailingId}/${listId}`;
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