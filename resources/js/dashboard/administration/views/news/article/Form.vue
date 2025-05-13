<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <form @submit.prevent="submit">
      <header class="content-header">
        <h1>{{ title }}</h1>
      </header>
      <div>

        <div :class="[this.errors.category_id ? 'has-error' : '', 'form-row']">
          <label>Kategorie</label>
          <div class="select-wrapper is-wide">
            <select v-model="article.category_id">
              <option value="null">Bitte wählen...</option>
              <option
                v-for="c in categories"
                :key="c.id"
                :value="c.id"
              >{{ c.title }}</option>
            </select>
          </div>
        </div>

        <div class="form-row">
          <label>Titel</label>
          <input type="text" v-model="article.title">
          <label-info text="Nur für Kursangebote"></label-info>
        </div>
        <div class="form-row">
          <label>Dozent/in</label>
          <div class="select-wrapper is-wide">
            <select v-model="article.tutor_id">
              <option value="null">Bitte wählen...</option>
              <option
                v-for="t in tutors"
                :key="t.id"
                :value="t.id"
              >{{ t.fullName }}</option>
            </select>
          </div>
          <label-info text="Nur für Kursangebote"></label-info>
        </div>
        <div class="form-row">
          <label>Datum</label>
          <input type="text" v-model="article.date">
          <label-info text="Nur für Kursangebote"></label-info>
        </div>
        <div :class="[this.errors.text ? 'has-error' : '', 'form-row']">
          <label>Text</label>
          <tinymce-editor
            :init="tinyConfig"
            v-model="article.text"
          ></tinymce-editor>
          <label-required/>
        </div>
        <div class="form-row">
          <label>Link</label>
          <input type="text" v-model="article.link">
        </div>
      </div>
      <footer class="module-footer">
        <div>
          <button type="submit" class="btn-primary">Speichern</button>
          <router-link :to="{ name: 'news-articles' }" class="btn-secondary">
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
import LabelInfo from "@/global/components/ui/LabelInfo.vue";

// TinyMCE
import tinyConfig from "@/global/config/tiny.js";
import TinymceEditor from "@tinymce/tinymce-vue";

export default {
  components: {
    LabelRequired,
    LabelInfo,
    TinymceEditor,
  },

  mixins: [ErrorHandling],

  props: {
    type: String
  },

  data() {
    return {
      // Model
      article: {
        title: '',
        date: '',
        text: '',
        link: '',
        is_published: 1,
        tutor_id: null,
        category_id: null
      },

      // Categories
      categories: [],

      // Tutors
      tutors: [],

      // Validation
      errors: {
        text: false,
        category_id: false,
      },

      // Loading state
      isLoading: false,
      isFetched: true,

      // TinyMCE
      tinyConfig: tinyConfig,
    };
  },

  created() {

    if (this.$props.type == "edit") {
      this.isFetched = false;
      let uri = `/api/news/article/${this.$route.params.id}`;
      this.axios.get(uri).then(response => {
        this.article = response.data;
        this.isFetched = true;
      });
    }

    const categories_uri = this.axios.get("/api/news/categories");
    const tutors_uri = this.axios.get("/api/tutors/active");

    this.axios.all([categories_uri, tutors_uri]).then(response => {
      this.categories = response[0].data.data;
      this.tutors = response[1].data.data;
      this.isLoading = false;
      this.isFetched = true;
    });
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
      let uri = "/api/news/article";
      this.isLoading = true;
      this.axios.post(uri, this.article).then(response => {
        this.$router.push({ name: "news-articles" });
        this.$notify({ type: "success", text: "Newsartikel erfasst!" });
        this.isLoading = false;
      });
    },

    update() {
      let uri = `/api/news/article/${this.$route.params.id}`;
      this.isLoading = true;
      this.axios.put(uri, this.article).then(response => {
        this.$router.push({ name: "news-articles" });
        this.$notify({ type: "success", text: "Newsartikel gespeichert!" });
        this.isLoading = false;
      });
    },
  },

  computed: {
    title: function() {
      return this.$props.type == "edit" ? "Artikel bearbeiten" : "Artikel hinzufügen";
    }
  }
};
</script>