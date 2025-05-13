<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <form @submit.prevent="submit">
      <header class="content-header">
        <h1>{{ title }}</h1>
      </header>
      <div>
        <div :class="[this.errors.title ? 'has-error' : '', 'form-row']">
          <label>Titel</label>
          <input type="text" v-model="category.title">
          <label-required />
        </div>
      </div>
      <footer class="module-footer">
        <div>
          <button type="submit" class="btn-primary">Speichern</button>
          <router-link :to="{ name: 'news-categories' }" class="btn-secondary">
            <span>Zurück</span>
          </router-link>
        </div>
      </footer>
    </form>
  </div>
</template>
<script>

// Error Handling
import ErrorHandling from "@/global/mixins/ErrorHandling";

// Components
import LabelRequired from "@/global/components/ui/LabelRequired.vue";

export default {
  components: {
    LabelRequired,
  },

  mixins: [ErrorHandling],

  props: {
    type: String
  },

  data() {
    return {
      // Model
      category: {
        title: '',
        is_published: 1,
      },
      // Validation
      errors: {
        title: false,
      },

      // Loading state
      isLoading: false,
      isFetched: true,
    };
  },

  created() {

    if (this.$props.type == "edit") {
      this.isFetched = false;
      let uri = `/api/news/category/${this.$route.params.id}`;
      this.axios.get(uri).then(response => {
        this.category = response.data;
        this.isFetched = true;
      });
    }
  },

  methods: {

    submit() {

      if (this.$props.type == "edit") {
        this.update();
      }

      if (this.$props.type == "create") {
        this.store();
      }
    },

    store() {
      let uri = "/api/news/category";
      this.isLoading = true;
      this.axios.post(uri, this.category).then(response => {
        this.$router.push({ name: "news-categories" });
        this.$notify({ type: "success", text: "Kategorie erfasst!" });
        this.isLoading = false;
      });
    },

    update() {
      let uri = `/api/news/category/${this.$route.params.id}`;
      this.isLoading = true;
      this.axios.put(uri, this.category).then(response => {
        this.$router.push({ name: "news-categories" });
        this.$notify({ type: "success", text: "Kategorie gespeichert!" });
        this.isLoading = false;
      });
    },
  },

  computed: {
    title: function() {
      return this.$props.type == "edit" ? "Kategorie bearbeiten" : "Kategorie hinzufügen";
    }
  }
};
</script>