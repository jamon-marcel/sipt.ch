<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <div :class="isFetched ? 'is-loaded' : 'is-loading'">
      <header class="content-header">
        <h1>Aufbau-Tipps</h1>
      </header>

      <div v-if="resilienceTips.length">
        <draggable
          v-model="resilienceTips"
          group="resilience-tips"
          handle=".drag-handle"
          :element="'div'"
          :options="{ animation: 200 }"
          @end="onDragEnd"
        >
          <div
            v-for="tip in resilienceTips"
            :key="tip.id"
            :class="[tip.is_published == 0 ? 'is-disabled' : '', 'listing__item']">
            <div class="listing__item-body is-draggable">
              <div class="drag-handle">
                <move-icon size="16"></move-icon>
              </div>
              <div>
                <strong>{{ tip.title }}</strong>
                <div v-if="tip.subtitle" style="font-size: 0.9em; color: #666; margin-top: 4px;">
                  {{ tip.subtitle }}
                </div>
              </div>
            </div>
            <list-actions
              :id="tip.id"
              :record="tip"
              :hasDestroy="true"
              :hasToggle="true"
              :isDraggable="true"
              :routes="{edit: 'resilience-tip-edit'}">
            </list-actions>
          </div>
        </draggable>
      </div>

      <div v-else>
        <p class="no-records">Es sind noch keine Einträge vorhanden...</p>
      </div>

      <footer class="module-footer">
        <div>
          <router-link :to="{ name: 'resilience-tip-create' }" class="btn-primary has-icon">
            <plus-icon size="16"></plus-icon>
            <span>Aufbau-Tipp hinzufügen</span>
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
      resilienceTips: [],
    };
  },

  created() {
    this.fetch();
  },

  methods: {
    fetch() {
      this.axios.get(`/api/resilience-tips`).then(response => {
        this.resilienceTips = response.data.data;
        this.isFetched = true;
      });
    },

    toggle(id, event) {
      const uri = `/api/resilience-tip/state/${id}`;
      this.isLoading = true;
      this.axios.get(uri).then(response => {
        const index = this.resilienceTips.findIndex(x => x.id === id);
        if (index !== -1) {
          this.resilienceTips[index].is_published = response.data;
        }
        this.$notify({ type: "success", text: "Status geändert" });
        this.isLoading = false;
      });
    },

    destroy(id, event) {
      if (confirm("Bitte löschen bestätigen!")) {
        const uri = `/api/resilience-tip/${id}`;
        this.isLoading = true;
        this.axios.delete(uri).then(() => {
          this.fetch();
          this.isLoading = false;
        });
      }
    },

    onDragEnd() {
      const reorderedIds = this.resilienceTips.map(tip => tip.id);
      this.axios.put(`/api/resilience-tips/order`, { ids: reorderedIds })
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
