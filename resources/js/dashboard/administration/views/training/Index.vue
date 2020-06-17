<template>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <header class="content-header">
      <h1>Fortbildungen</h1>
      <router-link :to="{ name: 'training-create' }" class="feather-icon feather-icon--prepend">
        <plus-icon size="16"></plus-icon>
        <span>Hinzufügen</span>
      </router-link>
    </header>
    <div class="listing is-grouped" v-if="trainings.length">
      <div class="listing-group" v-for="(trainings,index) in groupedTrainings" :key="index">
        <div v-for="(training, idx) in trainings" :key="idx">
          <h2 v-if="idx == 0">
            {{ training.category.name }}
          </h2>
          <div
            :class="[training.is_published == 0 ? 'is-disabled' : '', 'listing__item is-group']"
          >
            <div class="listing__item-body">
              {{ training.title }}
            </div>
            <list-actions 
              :id="training.id" 
              :record="training"
              :routes="{edit: 'training-edit'}">
            </list-actions>
          </div>
        </div>
      </div>
    </div>
    <div v-else>
      <p class="no-records">Es sind noch keine Trainings vorhanden...</p>
    </div>
  </div>
</template>
<script>

// Icons
import { PlusIcon } from 'vue-feather-icons';

// Components
import ListActions from "@/global/components/ui/ListActions.vue";


export default {

  components: {
    ListActions,
    PlusIcon
  },

  data() {
    return {
      isFetched: false,
      trainings: [],
    };
  },

  created() {
    this.fetch();
  },

  methods: {

    fetch() {
      this.axios.get(`/api/trainings`).then(response => {
        this.trainings = response.data.data;
        this.isFetched = true;
      });
    },

    toggle(id,event) {
      let uri = `/api/training/toggle/${id}`;
      this.axios.get(uri).then(response => {
        const index = this.trainings.findIndex(x => x.id === id);
        this.trainings[index].is_published = response.data;
        this.$notify({ type: "success", text: "Status geändert" });
      });
    },

    destroy(id, event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/training/destroy/${id}`;
        this.axios.delete(uri).then(response => {
          this.fetch();
        });
      }
    },
  },

  computed: {
    groupedTrainings() {
      return _.groupBy(this.trainings, "category_id")
    }
  }
}
</script>