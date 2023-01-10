<template>
  <div v-if="isFetched">
    <h2>Newsletter</h2>
    <div class="form-row is-sm" v-for="mailinglist in mailinglists" :key="mailinglist.id">
      <label class="is-sm">{{mailinglist.description}}</label>
      <div class="form-radio">
        <input
          type="radio"
          :name="mailinglist.id + '_1'"
          :id="mailinglist.id + '_1'"
          :value="mailinglist.id"
          class="visually-hidden"
          :checked="has(mailinglist.id) ? true : false"
          @change="add($event.target.value)"
        >
        <label :for="mailinglist.id + '_1'" class="form-control">Ja</label>
        <input
          type="radio"
          :name="mailinglist.id + '_0'"
          :id="mailinglist.id + '_0'"
          :value="mailinglist.id"
          class="visually-hidden"
          :checked="has(mailinglist.id) ? false : true"
          @change="remove($event.target.value)"
        >
        <label :for="mailinglist.id + '_0'" class="form-control">Nein</label>
      </div>
    </div>
  </div>
</template>
<script>
import RadioButton from "@/global/components/ui/RadioButton.vue";

export default {

  components: {
    RadioButton,
  },

  props: {
    email: {
      type: String,
      default: null
    },
  },

  data() {
    return {
      mailinglists: [],
      subscriptions: [],
      isFetched: true,
    };
  },

  mounted() {

    this.isFetched = false;
    this.axios.get(`/api/mailinglists`).then(response => {
      this.mailinglists = response.data.data;
      this.axios.get(`/api/mailinglists/subscriptions/${this.$props.email}`).then(response => {
        this.subscriptions = response.data;
        this.isFetched = true;
      });
    });
  },

  methods: {
    add(mailinglist) {
      const data = {
        email: this.$props.email,
        mailinglist: mailinglist
      }
      this.axios.post(`/api/mailinglist`, data).then(response => {
        this.subscriptions.push(response.data);
      });
    },

    remove(mailinglist) {
      const subscription = this.subscriptions.find(x => x.mailinglist_id == mailinglist);
      this.axios.delete(`/api/mailinglist/${subscription.id}`).then(response => {
        const index = this.subscriptions.findIndex(x => x.id == subscription.id);
        this.subscriptions.splice(index, 1);
      });
    },

    has(mailinglist) {
      return this.subscriptions.find(x => x.mailinglist_id == mailinglist) ? true : false;
    },
  }

}
</script>
