<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <header class="content-header">
      <h1>Mailings</h1>
      <router-link :to="{ name: 'mailing-create' }" class="feather-icon feather-icon--prepend">
        <plus-icon size="16"></plus-icon>
        <span>Hinzufügen</span>
      </router-link>
    </header>
    <div class="listing" v-if="mailings.length">
      <div
        class="listing__item"
        v-for="m in mailings"
        :key="m.id"
      >
        <div class="listing__item-body">
          <div>{{ m.subject | truncate(100, '...') }}<br>
            <!-- <template v-if="m.mailinglists.length">
              <span class="bubble bubble-mailing">
                {{ m.mailinglists.map(ml => ml.description.replace('Fachbereich', '')).join(', ') }}
              </span>
            </template> -->
            <template v-if="m.queue.length">
              <span :class="[m.processed == m.queued ? 'is-done' : '', 'bubble bubble-mailing-process']">
                Versand: {{ m.processed }}/{{ m.queued }}
              </span>
            </template>
          </div>
        </div>
        <list-actions 
          :id="m.id" 
          :record="m"
          :hasToggle="false"
          :hasMailingActivate="true"
          :hasMailingQueue="m.queue.length ? true : false"
          :routes="{edit: 'mailing-edit', 'queue': 'mailing-queue'}"
          @activate="activate(m.id)">
        </list-actions>
      </div>
    </div>
    <div v-else>
      <p class="no-records">Es sind noch keine Mailings vorhanden...</p>
    </div>
  </div>
  <activate-selector ref="activateSelector"></activate-selector>
</div>
</template>
<script>

// Icons
import { PlusIcon } from 'vue-feather-icons';

// Components
import ListActions from "@/global/components/ui/ListActions.vue";
import ActivateSelector from '@/administration/views/mailing/components/ActivateSelector.vue';

export default {

  components: {
    ListActions,
    PlusIcon,
    ActivateSelector
  },

  data() {
    return {
      isLoading: false,
      isFetched: false,
      mailings: [],
    };
  },

  created() {
    this.fetch();
  },

  methods: {

    fetch() {
      this.axios.get(`/api/mailings`).then(response => {
        this.mailings = response.data.data;
        this.isFetched = true;
      });
    },

    destroy(id, event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/mailing/${id}`;
        this.isLoading = true;
        this.axios.delete(uri).then(response => {
          this.fetch();
          this.isLoading = false;
        });
      }
    },
   
    activate(id) {
      this.$refs.activateSelector.show(id);
    }
  },
}
</script>