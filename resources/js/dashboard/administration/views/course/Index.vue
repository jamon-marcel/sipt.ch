<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <header class="content-header">
      <h1>Module</h1>
      <router-link :to="{ name: 'course-create' }" class="feather-icon feather-icon--prepend">
        <plus-icon size="16"></plus-icon>
        <span>Hinzufügen</span>
      </router-link>
    </header>
    <div class="listing" v-if="courses.length">
      <div
        :class="[c.is_published == 0 ? 'is-disabled' : '', 'listing__item']"
        v-for="c in courses"
        :key="c.id"
      >
        <div class="listing__item-body">
          {{ c.number }} – {{ c.title }}
        </div>
        <list-actions
          :id="c.id" 
          :record="c"
          :hasEvent="true"
          :eventCount="c.events_upcoming.length"
          :routes="{edit: 'course-edit', events: 'course-events'}">
        </list-actions>
      </div>
    </div>
    <div v-else>
      <p>Es sind noch keine Module vorhanden...</p>
    </div>
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
      courses: [],
      isLoading: false,
      isFetched: false,
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
      let uri = `/api/course/state/${id}`;
      this.isLoading = true;
      this.axios.get(uri).then(response => {
        const idx = this.courses.findIndex(x => x.id === id);
        this.courses[idx].is_published = response.data;
        this.$notify({ type: "success", text: "Status geändert" });
        this.isLoading = false;
      });
    },

    destroy(id, event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/course/${id}`;
        this.isLoading = true;
        this.axios.delete(uri).then(response => {
          this.fetch();
          this.isLoading = false;
        });
      }
    },
  }
}
</script>