<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <header class="content-header">
      <h1>News-Artikel</h1>
    </header>
    <div class="listing" v-if="news_articles.length">
      <div
        class="listing__item"
        v-for="n in news_articles"
        :key="n.id"
      >
        <div class="listing__item-body">
          <div>{{ n.title }}</div>
        </div>
        <list-actions 
          :id="n.id" 
          :record="n"
          :hasDestroy="true"
          :hasToggle="true"
          :routes="{edit: 'news-article-edit'}">
        </list-actions>
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
          <router-link :to="{ name: 'news-article-create' }" class="btn-secondary has-icon">
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

// Icons
import { PlusIcon, MenuIcon } from 'vue-feather-icons';

// Components
import ListActions from "@/global/components/ui/ListActions.vue";

export default {

  components: {
    ListActions,
    PlusIcon,
    MenuIcon
  },

  data() {
    return {
      isLoading: false,
      isFetched: false,
      news_articles: [],
    };
  },

  created() {
    this.fetch();
  },

  methods: {

    fetch() {
      this.axios.get(`/api/news/articles`).then(response => {
        this.news_articles = response.data.data;
        this.isFetched = true;
      });
    },

    destroy(id, event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/news/articles/${id}`;
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