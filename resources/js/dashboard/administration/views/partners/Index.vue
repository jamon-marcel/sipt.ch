<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <div :class="isFetched ? 'is-loaded' : 'is-loading'">
      <header class="content-header">
        <h1>Partner-Institutionen</h1>
      </header>

      <div v-if="institutions.length">
        <draggable
          v-model="institutions"
          group="institutions"
          handle=".drag-handle"
          :element="'div'"
          :options="{ animation: 200 }"
          @end="onDragEnd"
        >
          <div
            v-for="institution in institutions"
            :key="institution.id"
            :class="[institution.is_published == 0 ? 'is-disabled' : '', 'listing__item']">
            <div class="listing__item-body is-draggable">
              <div class="drag-handle">
                <move-icon size="16"></move-icon>
              </div>
              <div>
                <strong>{{ institution.name }}</strong>
              </div>
            </div>
            <list-actions
              :id="institution.id"
              :record="institution"
              :hasDestroy="true"
              :hasToggle="true"
              :isDraggable="true"
              :routes="{edit: 'partner-edit'}">
            </list-actions>
          </div>
        </draggable>
      </div>

      <div v-else>
        <p class="no-records">Es sind noch keine Einträge vorhanden...</p>
      </div>

      <footer class="module-footer">
        <div>
          <router-link :to="{ name: 'partner-create' }" class="btn-primary has-icon">
            <plus-icon size="16"></plus-icon>
            <span>Hinzufügen</span>
          </router-link>
        </div>
      </footer>
    </div>
  </div>
</template>

<script>
import draggable from 'vuedraggable';
import ListActions from "@/global/components/ui/ListActions.vue";
import { PlusIcon, MoveIcon } from 'vue-feather-icons';

export default {
  components: {
    ListActions,
    PlusIcon,
    MoveIcon,
    draggable
  },
  data() {
    return {
      isLoading: false,
      isFetched: false,
      institutions: [],
    };
  },
  created() {
    this.fetch();
  },
  methods: {
    fetch() {
      this.axios.get(`/api/partner-institutions`).then(response => {
        this.institutions = response.data.data;
        this.isFetched = true;
      });
    },

    toggle(id, event) {
      const uri = `/api/partner-institution/state/${id}`;
      this.isLoading = true;
      this.axios.get(uri).then(response => {
        const index = this.institutions.findIndex(x => x.id === id);
        if (index !== -1) {
          this.institutions[index].is_published = response.data;
        }
        this.$notify({ type: "success", text: "Status geändert" });
        this.isLoading = false;
      });
    },

    destroy(id, event) {
      if (confirm("Bitte löschen bestätigen!")) {
        const uri = `/api/partner-institution/${id}`;
        this.isLoading = true;
        this.axios.delete(uri).then(() => {
          this.fetch();
          this.isLoading = false;
        });
      }
    },

    onDragEnd() {
      const reorderedIds = this.institutions.map(i => i.id);
      this.axios.put(`/api/partner-institutions/order`, { ids: reorderedIds })
      .then(() => {
        this.$notify({ type: "success", text: "Reihenfolge gespeichert" });
      })
      .catch(() => {
        this.$notify({ type: "error", text: "Fehler beim Speichern der Reihenfolge" });
      });
    }
  }
};
</script>
