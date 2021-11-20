<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <header class="content-header">
      <h1>Veranstaltungsorte</h1>
      <router-link :to="{ name: 'location-create' }" class="feather-icon feather-icon--prepend">
        <plus-icon size="16"></plus-icon>
        <span>Hinzufügen</span>
      </router-link>
    </header>
    <div class="listing" v-if="locations.length">
      <div
        :class="[l.is_published == 0 ? 'is-disabled' : '', 'listing__item']"
        v-for="l in locations"
        :key="l.id"
      >
        <div class="listing__item-body">
          {{l.name }} <separator />{{ l.city }}
        </div>
        <list-actions 
          :id="l.id" 
          :record="l"
          :hasToggle="false"
          :routes="{edit: 'location-edit'}">
        </list-actions>
      </div>
    </div>
    <div v-else>
      <p class="no-records">Es sind noch keine Veranstaltungsorte vorhanden...</p>
    </div>
  </div>
</div>
</template>
<script>

// Icons
import { PlusIcon } from 'vue-feather-icons';

// Components
import ListActions from "@/global/components/ui/ListActions.vue";

export default {

  components: {
    ListActions,
    PlusIcon
  },

  data() {
    return {
      isLoading: false,
      isFetched: false,
      locations: [],
    };
  },

  created() {
    this.fetch();
  },

  methods: {

    fetch() {
      this.axios.get(`/api/locations`).then(response => {
        this.locations = response.data.data;
        this.isFetched = true;
      });
    },

    destroy(id, event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/location/${id}`;
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