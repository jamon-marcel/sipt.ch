<template>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <header class="content-header">
      <h1>Module</h1>
      <router-link :to="{ name: 'course-create' }" class="feather-icon feather-icon--prepend">
        <plus-icon size="18"></plus-icon>
        <span>Hinzufügen</span>
      </router-link>
    </header>
    <div class="listing" v-if="courses.length">
      <div
        :class="[c.is_published == 0 ? 'is-disabled' : '', 'listing__item']"
        v-for="c in courses"
        :key="c.id"
        data-icons="4"
      >
        <div class="listing__item-body">
          {{ c.title }}
        </div>
        <list-actions
          :id="c.id" 
          :count="4" 
          :record="c"
          :hasEvent="true"
          :eventCount="c.events.length"
          :routes="{edit: 'course-edit', events: 'course-events'}">
        </list-actions>
      </div>
    </div>
    <div v-else>
      <p>Es sind noch keine Module vorhanden...</p>
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
      courses: []
    };
  },

  created() {
    this.fetch();
  },

  methods: {

    fetch() {
      this.axios.get(`/api/courses`).then(response => {
        this.courses = response.data.data;
        this.isFetched = true;
      });
    },

    toggle(id,event) {
      let uri = `/api/course/toggle/${id}`;
      this.axios.get(uri).then(response => {
        const index = this.courses.findIndex(x => x.id === id);
        this.courses[index].is_published = response.data;
        this.$notify({ type: "success", text: "Status geändert" });
      });
    },

    destroy(id, event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/course/destroy/${id}`;
        this.axios.delete(uri).then(response => {
          this.fetch();
        });
      }
    },
  }
}
</script>