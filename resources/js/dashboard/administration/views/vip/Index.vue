<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <header class="content-header">
      <h1>VIP Adressen</h1>
      <router-link :to="{ name: 'vip-address-create' }" class="feather-icon feather-icon--prepend">
        <plus-icon size="16"></plus-icon>
        <span>Hinzufügen</span>
      </router-link>
    </header>
    <div class="listing" v-if="addresses.length">
      <div
        class="listing__item"
        v-for="a in addresses"
        :key="a.id"
      >
        <div class="listing__item-body">
          {{a.name }} <separator /> {{ a.firstname}} <separator /> {{ a.city }}
          <span v-if="a.company">
            <separator />{{ a.company }}
          </span>
        </div>
        <list-actions 
          :id="a.id" 
          :record="a"
          :hasToggle="false"
          :routes="{edit: 'vip-address-edit'}">
        </list-actions>
      </div>
    </div>
    <div v-else>
      <p class="no-records">Es sind noch keine VIP-Adressen vorhanden...</p>
    </div>
    <footer class="module-footer">
      <div class="flex-fe flex-vc">
        <a :href="'/export/adressliste/vip?v=' + randomString()" class="btn-primary has-icon" target="_blank">
          <download-icon size="16"></download-icon>
          <span>Export VIP</span>
        </a>
        <a :href="'/export/adressliste/dozenten?v=' + randomString()" class="btn-primary has-icon" target="_blank">
          <download-icon size="16"></download-icon>
          <span>Export Dozenten</span>
        </a>
        <a :href="'/export/adressliste/studenten?v=' + randomString()" class="btn-primary has-icon" target="_blank">
          <download-icon size="16"></download-icon>
          <span>Export Studenten</span>
        </a>
      </div>
    </footer>
  </div>
</div>
</template>
<script>

// Icons
import { PlusIcon, DownloadIcon } from 'vue-feather-icons';

// Mixins
import Helpers from "@/global/mixins/Helpers";
import DateTime from "@/global/mixins/DateTime";
import ErrorHandling from "@/global/mixins/ErrorHandling";

// Components
import ListActions from "@/global/components/ui/ListActions.vue";

export default {

  components: {
    ListActions,
    PlusIcon, 
    DownloadIcon
  },

  mixins: [Helpers, DateTime, ErrorHandling],


  data() {
    return {
      isLoading: false,
      isFetched: false,
      addresses: []
    };
  },

  created() {
    this.fetch();
  },

  methods: {

    fetch() {
      this.axios.get(`/api/vip-addresses`).then(response => {
        this.addresses = response.data.data;
        this.isFetched = true;
      });
    },

    destroy(id, event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/vip-address/${id}`;
        this.isLoading = true;
        this.axios.delete(uri).then(response => {
          this.fetch();
          this.isLoading = false;
        });
      }
    },
  }
}
</script>