<template>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <header class="content-header">
      <h1>Modul: <strong>{{course.title}}</strong></h1>
    </header>
    <template v-if="isFetched">
      <label class="flex-sb">
        <span>Veranstaltungen</span>
        <router-link :to="{ name: 'course-event-create', params: { id: course.id } }" class="feather-icon feather-icon--prepend">
          <plus-icon size="16"></plus-icon>
          <span>Hinzufügen</span>
        </router-link>
      </label>
      <div class="listing" v-if="course.events.length">
        <div
          :class="[c.is_published == 0 ? 'is-disabled' : '', 'listing__item']"
          v-for="c in course.events"
          :key="c.id"
        >
          <div class="listing__item-body">
            <span class="item-date">{{ datesToString(c.dates) }}</span>
            <span class="separator">&bull;</span>
            <span v-if="c.location_id != 'null' && c.is_online == 0">{{ c.location.name_short }}, {{ c.location.city }}</span>
            <span v-else>Online</span>
            <span class="separator">&bull;</span>
            {{ tutorsToString(c.dates) }}
            <em class="bubble-danger" v-if="c.is_cancelled">Abgesagt</em>
          </div>
          <list-actions
            :id="c.id" 
            :record="c"
            :hasDetail="true"
            :routes="{edit: 'course-event-edit', details: 'course-event-show'}">
          </list-actions>
        </div>
      </div>  
      <div v-else>
        <p class="no-records">Es sind noch keine Daten für dieses Modul vorhanden...</p>
      </div>
    </template>



    
    <footer class="module-footer">
      <div>
        <router-link :to="{ name: 'courses' }" class="btn-secondary">
          <span>Zurück</span>
        </router-link>
      </div>
    </footer>
  </div>
</template>
<script>

// Icons
import { PlusIcon, ArrowLeftIcon } from 'vue-feather-icons';

// Components
import ListActions from "@/global/components/ui/ListActions.vue";

// Mixins
import Helpers from "@/global/mixins/Helpers";

export default {

  components: {
    ListActions,
    PlusIcon,
    ArrowLeftIcon
  },

  mixins: [Helpers],

  data() {
    return {
      isFetched: false,
      course: {},
    };
  },

  created() {
    this.fetch();
  },

  methods: {

    fetch() {
      this.axios.get(`/api/course/${this.$route.params.id}`).then(response => {
        this.course = response.data;
        this.isFetched = true;
      });
    },

    toggle(id,event) {
      let uri = `/api/course/event/toggle/${id}`;
      this.axios.get(uri).then(response => {
        const index = this.course.events.findIndex(x => x.id === id);
        this.course.events[index].is_published = response.data;
        this.$notify({ type: "success", text: "Status geändert" });
      });
    },

    destroy(id, event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/course/event/destroy/${id}`;
        this.axios.delete(uri).then(response => {
          this.fetch();
        });
      }
    },
  }
}
</script>