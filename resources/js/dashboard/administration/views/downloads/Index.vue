<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <div :class="isFetched ? 'is-loaded' : 'is-loading'">
      <header class="content-header">
        <h1>Downloads</h1>
      </header>

      <div v-if="downloads.length">
        <draggable
          v-model="downloads"
          group="downloads"
          handle=".drag-handle"
          :element="'div'"
          @end="onDragEnd"
        >
          <div
            v-for="d in downloads"
            :key="d.id"
            :class="[d.is_published == 0 ? 'is-disabled' : '', 'listing__item']">
            <div class="listing__item-body is-draggable">
              <div class="drag-handle">
                <move-icon size="16"></move-icon>
              </div>
              <div>
                <strong>{{ d.title }}</strong>
              </div>
            </div>
            <list-actions
              :id="d.id"
              :record="d"
              :hasDestroy="true"
              :hasToggle="true"
              :isDraggable="true"
              :routes="{edit: 'download-edit'}">
            </list-actions>
          </div>
        </draggable>
      </div>

      <div v-else>
        <p class="no-records">Es sind noch keine Einträge vorhanden...</p>
      </div>

      <footer class="module-footer">
        <div>
          <router-link :to="{ name: 'download-create' }" class="btn-primary has-icon">
            <plus-icon size="16"></plus-icon>
            <span>Download hinzufügen</span>
          </router-link>
        </div>
      </footer>
    </div>
  </div>
</template>

<script>
// Vue draggable
import draggable from 'vuedraggable';

// Icons
import { PlusIcon, MoveIcon } from 'vue-feather-icons';

// Components
import ListActions from "@/global/components/ui/ListActions.vue";
import Separator from "@/global/components/ui/Separator.vue";

export default {
  components: {
    ListActions,
    PlusIcon,
    MoveIcon,
    draggable,
    Separator,
  },

  data() {
    return {
      isLoading: false,
      isFetched: false,
      downloads: [],
    };
  },

  created() {
    this.fetch();
  },

  methods: {
    fetch() {
      this.axios.get(`/api/downloads`).then(response => {
        this.downloads = response.data.data;
        this.isFetched = true;
      });
    },

    toggle(id, event) {
      const uri = `/api/download/state/${id}`;
      this.isLoading = true;
      this.axios.get(uri).then(response => {
        const index = this.downloads.findIndex(x => x.id === id);
        if (index !== -1) {
          this.downloads[index].is_published = response.data;
        }
        this.$notify({ type: "success", text: "Status geändert" });
        this.isLoading = false;
      });
    },

    destroy(id, event) {
      if (confirm("Bitte löschen bestätigen!")) {
        const uri = `/api/download/${id}`;
        this.isLoading = true;
        this.axios.delete(uri).then(() => {
          this.fetch();
          this.isLoading = false;
        });
      }
    },

    onDragEnd() {
      const reorderedIds = this.downloads.map(d => d.id);
      this.axios.put(`/api/downloads/order`, { ids: reorderedIds })
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

<style scoped>
.file-type-badge {
  display: inline-block;
  padding: 2px 6px;
  background: #e0e0e0;
  border-radius: 3px;
  font-size: 0.85em;
  font-weight: 600;
  margin-right: 8px;
}
</style>
