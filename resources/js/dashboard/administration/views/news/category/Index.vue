<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <header class="content-header">
      <h1>News-Kategorien</h1>
    </header>
    <div class="listing" v-if="categories.length">
      <draggable
        v-model="categories"
        group="categories"
        handle=".drag-handle"
        :element="'div'"
        @end="onDragEnd"
      >
        <div
          v-for="c in categories"
          :key="c.id"
          :class="[c.is_published == 0 ? 'is-disabled' : '', 'listing__item']"
        >
          <div class="listing__item-body is-draggable">
            <div class="drag-handle">
              <move-icon size="16"></move-icon>
            </div>
            <div>{{ c.title }}</div>
          </div>
          <list-actions 
            :id="c.id" 
            :record="c"
            :hasDestroy="true"
            :hasToggle="true"
            :isDraggable="true"
            :routes="{edit: 'news-category-edit'}">
          </list-actions>
        </div>
      </draggable>

    </div>
    <div v-else>
      <p class="no-records">Es sind noch keine Einträge vorhandec...</p>
    </div>
    <footer class="module-footer">
      <div class="flex-fe flex-sb">
        <div>
          <router-link :to="{ name: 'news-category-create' }" class="btn-primary has-icon">
            <plus-icon size="16"></plus-icon>
            <span>Kategorie hinzufügen</span>
          </router-link>
        </div>
        <div>
          <router-link :to="{ name: 'news-articles' }" class="btn-secondary has-icon">
            <arrow-left-icon size="16"></arrow-left-icon>
            <span>Zurück</span>
          </router-link>
        </div>
      </div>
    </footer>
  </div>
</div>
</template>
<script>

// Vue draggable
import draggable from 'vuedraggable';

// Icons
import { PlusIcon, ArrowLeftIcon, MoveIcon } from 'vue-feather-icons';

// Components
import ListActions from "@/global/components/ui/ListActions.vue";

export default {

  components: {
    ListActions,
    PlusIcon,
    ArrowLeftIcon,
    MoveIcon,
    draggable
  },

  data() {
    return {
      isLoading: false,
      isFetched: false,
      categories: [],
    };
  },

  created() {
    this.fetch();
  },

  methods: {

    fetch() {
      this.axios.get(`/api/news/categories`).then(response => {
        this.categories = response.data.data;
        this.isFetched = true;
      });
    },

    toggle(id,event) {
      let uri = `/api/news/category/state/${id}`;
      this.isLoading = true;
      this.axios.get(uri).then(response => {
        const index = this.categories.findIndex(x => x.id === id);
        this.categories[index].is_published = response.data;
        this.$notify({ type: "success", text: "Status geändert" });
        this.isLoading = false;
      });
    },

    destroy(id, event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/news/category/${id}`;
        this.isLoading = true;
        this.axios.delete(uri).then(response => {
          this.fetch();
          this.isLoading = false;
        });
      }
    },

    onDragEnd(event) {
      const reorderedIds = this.categories.map(c => c.id);
      this.axios.post('/api/news/categories/order', { ids: reorderedIds })
      .then(() => {
        this.$notify({ type: "success", text: "Reihenfolge gespeichert" });
      })
      .catch(() => {
        this.$notify({ type: "error", text: "Fehler beim Speichern der Reihenfolge" });
      });
    }
  },
}
</script>