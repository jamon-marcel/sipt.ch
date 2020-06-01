<template>
  <div :class="isLoaded ? 'is-loaded' : 'hide-before-load'">
    <header class="module-header">
      <h1>Fortbildungen</h1>
      <router-link :to="{ name: 'training-create' }" class="btn-add">
        <span>Hinzufügen</span>
      </router-link>
    </header>
    <div class="listing" v-if="trainings.length">
      <div
        :class="[t.is_published == 0 ? 'is-disabled' : '', 'listing__item']"
        v-for="t in trainings"
        :key="t.id"
        data-icons="3"
      >
        <div class="listing__item-body">
          {{ t.title }}
        </div>
        <list-actions 
          :count="3" 
          :record="t"
          :routes="{edit: 'training-edit'}">
        </list-actions>
      </div>
    </div>
    <div v-else>
      <p>Es sind noch keine Trainings vorhanden...</p>
    </div>
  </div>
</template>
<script>

// Components
import ListActions from "@/global/components/ui/ListActions.vue";

// Mixins
import Progress from "@/global/mixins/progress";

export default {

  components: {
    ListActions
  },

  mixins: [Progress],

  data() {
    return {
      isLoaded: false,
      trainings: []
    };
  },


  created() {
    this.fetch();
  },

  methods: {

    fetch() {
      this.axios.get(`/api/trainings`).then(response => {
        this.trainings = response.data.data;
        this.isLoaded = true;
      });
    },

    toggle(id,event) {
      let uri = `/api/training/toggle/${id}`;
      let el = this.progress(event.target);
      this.axios.get(uri).then(response => {
        const index = this.trainings.findIndex(x => x.id === id);
        this.trainings[index].is_published = response.data;
        this.$notify({ type: "success", text: "Status geändert" });
        this.progress(el);
      });
    },

    destroy(id, event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let el = this.progress(event.target);
        let uri = `/api/training/destroy/${id}`;
        this.axios.delete(uri).then(response => {
          this.fetch();
          this.progress(el);
        });
      }
    },
  }
}
</script>
<style>
.is-loaded {
  opacity: 1;
  transition: opacity .12s ease-out;
}

.hide-before-load {
  opacity: 0;
  transition: opacity .12s ease-out;
}

</style>
