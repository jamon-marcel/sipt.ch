<template>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <header class="content-header">
      <h1>Studenten</h1>
    </header>
    <div class="listing" v-if="students.length">
      <div
        :class="[s.is_published == 0 ? 'is-disabled' : '', 'listing__item']"
        v-for="s in students"
        :key="s.id"
        data-icons="1"
      >
        <div class="listing__item-body">
          {{s.firstname }} {{ s.name}}<span class="separator">&bull;</span>
          {{ s.title }}<span class="separator">&bull;</span>
          {{ s.city }}
        </div>
        <list-actions 
          :id="s.id" 
          :count="1"
          :hasToggle="false"
          :hasDestroy="false" 
          :hasEdit="false"
          :hasShow="true"
          :record="s"
          :routes="{show: 'student-show'}">
        </list-actions>
      </div>
    </div>
    <div v-else>
      <p class="no-records">Es sind noch keine Studenten vorhanden...</p>
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
  },

  data() {
    return {
      isFetched: false,
      students: []
    };
  },

  created() {
    this.fetch();
  },

  methods: {

    fetch() {
      this.axios.get(`/api/students`).then(response => {
        this.students = response.data.data;
        this.isFetched = true;
      });
    },

    destroy(id, event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/student/destroy/${id}`;
        this.axios.delete(uri).then(response => {
          this.fetch();
        });
      }
    },
  }
}
</script>