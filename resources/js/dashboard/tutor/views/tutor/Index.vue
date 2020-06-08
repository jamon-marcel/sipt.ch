<template>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <header class="module-header">
      <h1>Dozenten</h1>
      <router-link :to="{ name: 'tutor-create' }" class="feather-icon feather-icon--prepend">
        <plus-icon size="18"></plus-icon>
        <span>Hinzufügen</span>
      </router-link>
    </header>
    <div class="listing" v-if="tutors.length">
      <div
        :class="[t.is_published == 0 ? 'is-disabled' : '', 'listing__item']"
        v-for="t in tutors"
        :key="t.id"
        data-icons="3"
      >
        <div class="listing__item-body">
          <span v-if="t.title">{{t.title}}</span>&nbsp;{{t.firstname }} {{ t.name}}<span class="separator">&bull;</span>{{ t.city }}
        </div>
        <list-actions 
          :id="t.id" 
          :count="3" 
          :record="t"
          :routes="{edit: 'tutor-edit'}">
        </list-actions>
      </div>
    </div>
    <div v-else>
      <p>Es sind noch keine Dozenten vorhanden...</p>
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
      tutors: []
    };
  },

  created() {
    this.fetch();
  },

  methods: {

    fetch() {
      this.axios.get(`/api/tutors`).then(response => {
        this.tutors = response.data.data;
        this.isFetched = true;
      });
    },

    toggle(id,event) {
      let uri = `/api/tutor/toggle/${id}`;
      this.axios.get(uri).then(response => {
        const index = this.tutors.findIndex(x => x.id === id);
        this.tutors[index].is_published = response.data;
        this.$notify({ type: "success", text: "Status geändert" });
      });
    },

    destroy(id, event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/tutor/destroy/${id}`;
        this.axios.delete(uri).then(response => {
          this.fetch();
        });
      }
    },
  }
}
</script>