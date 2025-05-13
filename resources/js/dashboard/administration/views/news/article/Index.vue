<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <div :class="isFetched ? 'is-loaded' : 'is-loading'">
      <header class="content-header">
        <h1>Artikel</h1>
      </header>

      <div v-if="categories.length">
        <div 
          v-for="cat in categories" 
          :key="cat.id" 
          class="listing-group"
          v-if="cat.articles.length">
          <h2>{{ cat.title }}</h2>
          <draggable
            v-model="cat.articles"
            :group="`articles-${cat.id}`"
            handle=".drag-handle"
            :element="'div'"
            :options="{ animation: 200 }"
            @end="() => onDragEnd(cat.id)"
          >
            <div
              v-for="a in cat.articles"
              :key="a.id"
              :class="[a.is_published == 0 ? 'is-disabled' : '', 'listing__item']">
              <div class="listing__item-body is-draggable">
                <div class="drag-handle">
                  <move-icon size="16"></move-icon>
                </div>
                <div v-if="a.title">
                  {{ a.title }}
                  <template v-if="a.date">
                    <separator/>
                    {{ a.date }}
                  </template>
                </div>
                <div v-else>
                  <span v-html="truncate(a.text, 100, '...')"></span>
                </div>
              </div>
              <list-actions 
                :id="a.id" 
                :record="a"
                :hasDestroy="true"
                :hasToggle="true"
                :isDraggable="true"
                :routes="{edit: 'news-article-edit'}">
              </list-actions>
            </div>
          </draggable>
        </div>
      </div>

      <div v-else>
        <p class="no-records">Es sind noch keine Einträge vorhanden...</p>
      </div>

      <footer class="module-footer">
        <div class="flex-fe flex-sb">
          <div>
            <router-link :to="{ name: 'news-article-create' }" class="btn-primary has-icon">
              <plus-icon size="16"></plus-icon>
              <span>Artikel hinzufügen</span>
            </router-link>
          </div>
          <div>
            <router-link :to="{ name: 'news-categories' }" class="btn-secondary has-icon">
              <menu-icon size="16"></menu-icon>
              <span>Kategorien verwalten</span>
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
import { PlusIcon, MenuIcon, MoveIcon } from 'vue-feather-icons';

// Components
import ListActions from "@/global/components/ui/ListActions.vue";
import Separator from "@/global/components/ui/Separator.vue";

export default {
  components: {
    ListActions,
    PlusIcon,
    MenuIcon,
    MoveIcon,
    draggable,
    Separator,
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
      this.axios.get(`/api/news/articles`).then(response => {
        this.categories = response.data.data;
        this.isFetched = true;
      });
    },

    toggle(id, event) {
      const uri = `/api/news/article/state/${id}`;
      this.isLoading = true;
      this.axios.get(uri).then(response => {
        for (const cat of this.categories) {
          const index = cat.articles.findIndex(x => x.id === id);
          if (index !== -1) {
            cat.articles[index].is_published = response.data;
            break;
          }
        }
        this.$notify({ type: "success", text: "Status geändert" });
        this.isLoading = false;
      });
    },

    destroy(id, event) {
      if (confirm("Bitte löschen bestätigen!")) {
        const uri = `/api/news/article/${id}`;
        this.isLoading = true;
        this.axios.delete(uri).then(() => {
          this.fetch();
          this.isLoading = false;
        });
      }
    },

    truncate(text, length = 100, suffix = "...") {
      if (!text) return '';

      // Remove HTML tags using a regular expression
      const strippedText = text.replace(/<[^>]*>/g, '');

      return strippedText.length > length
        ? strippedText.substring(0, length) + suffix
        : strippedText;
    },

    onDragEnd(categoryId) {
      const category = this.categories.find(cat => cat.id === categoryId);
      if (!category) return;

      const reorderedIds = category.articles.map(a => a.id);
      this.axios.put(`/api/news/articles/order/${categoryId}`, { ids: reorderedIds })
      .then(() => {
        this.$notify({ type: "success", text: "Artikel-Reihenfolge gespeichert" });
      })
      .catch(() => {
        this.$notify({ type: "error", text: "Fehler beim Speichern der Reihenfolge" });
      });
    }
  }
};
</script>
