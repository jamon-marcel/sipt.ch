<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  <div class="overlay is-visible" v-if="isOpen && isFetched">
    <div class="overlay__inner">
      <div>
        <a href @click.prevent="hide()" class="feather-icon">
          <x-icon size="24"></x-icon>
        </a>
        <h1>Versand</h1>
        <div class="sa-md">
          <div class="form-row is-sm">
            <label>Mailing als Test an:</label>
            <input type="text" v-model="email">
          </div>
          <div class="form-row" v-if="hasPreviewUser">
            <button class="btn-primary" @click="preview()">Testmail senden</button>
          </div>
        </div>
        <div class="border-top-2 pt-sm">
          <div class="form-row is-sm">
            <label>Mailing an folgende Liste senden:</label>
            <div class="checkbox-wrapper" v-for="l in lists" :key="l.id">
              <input type="checkbox" :id="l.id" :name="l.id" :value="l.id" v-model="list_ids">
              <label :for="l.id">{{ l.description }}</label>
            </div>
          </div>
          <div v-if="canSend" class="alert">
            <h2>Versand bestätigen</h2>
            <p>Bitte Versand an <strong>{{ active_subscribers_count }} Abonnenten</strong> bestätigen. Die E-Mail-Adressen der Abonnenten werden in die Warteschlange eingereiht und im Minutentakt versendet.</p>
            <button class="btn-primary" @click="store()" :disabled="isLoading ? true : false">
              <strong>Versand starten</strong>
            </button>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
</template>
<script>
import { XIcon } from 'vue-feather-icons';
import ErrorHandling from "@/global/mixins/ErrorHandling";

export default {

  components: {
    XIcon
  },

  mixins: [ErrorHandling],

  data() {
    return {
      email: null,
      mailing_id: null,
      list_ids: [],
      lists: [],
      active_subscribers_count: 0,

      isLoading: false,
      isOpen: false,
      hasPreviewUser: false,
      canSend: false,
    }
  },

  created() {
    const onEscape = (e) => {
      if (this.isOpen && e.keyCode === 27) {
        this.hide();
      }
    }
    document.addEventListener('keydown', onEscape);
    this.fetchLists();
    this.fetchUser();
  },

  methods: {

    fetchUser() {
      this.axios.get(`/api/user/admin`).then(response => {
        this.email = response.data.email;
        this.hasPreviewUser = true;
      });
    },

    fetchLists() {
      this.isFetched = false;
      let uri = `/api/mailinglists/true`;
      this.axios.get(uri).then(response => {
        this.lists = response.data.data;
        this.isFetched = true;
      });
    },

    show(mailing_id = null) {
      this.mailing_id = mailing_id;
      this.isOpen = true;
    },

    hide() {
      this.reset();
      this.isOpen = false;
    },

    reset() {
      this.email = null;
      this.list_ids = [];
      this.active_subscribers_count = 0;
      this.canSend = false;
    },

    preview() {
      this.isLoading = true;
      const data = {
        mailing_id: this.mailing_id,
        email: this.email
      };
      this.axios.post(`/api/mailingqueue/preview`, data).then(response => {
        this.$notify({ type: "success", text: "Vorschau gesendet!" });
        this.isLoading = false;
        this.$parent.fetch();
        this.hide();
      });
    },

    store() {
      this.isLoading = true;
      const data = {
        mailing_id: this.mailing_id,
        list_ids: this.list_ids,
      };
      this.axios.post(`/api/mailingqueue/store`, data).then(response => {
        this.$notify({ type: "success", text: "Liste(n) erfasst!" });
        this.isLoading = false;
        this.$parent.fetch();
        this.hide();
      });
    },

    validEmail() {
      const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
      return regex.test(this.email);
    }
  },

  watch: {
    list_ids: function (val) {
      this.canSend = val.length > 0;
      let count = 0;
      val.forEach(id => {
        let list = this.lists.find(l => l.id == id);
        if (list) {
          count += list.active_subscribers_count;
        }
      });
      this.active_subscribers_count = count;
    }
  }
}
</script>