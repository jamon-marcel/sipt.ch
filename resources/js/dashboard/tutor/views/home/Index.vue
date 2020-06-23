<template>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <header class="content-header">
      <h1>
        Willkommen
        <strong>{{tutor.firstname}} {{tutor.name}}</strong>
      </h1>
    </header>
    <div class="content">
      <p>Unser neues Portal für ermöglicht es Ihnen, ihre persönlichen Daten selbständig zu aktualisieren sowie ihre Module zu verwalten.</p>
      <h2 class="sb-md">Ihre nächsten Module</h2>
      <course-events-list
        :records="courseEvents"
        :isTutor="true"
        :hasDestroy="false"
        v-if="courseEvents.length"
      ></course-events-list>
      <div class="no-records" v-else>Keine Module vorhanden...</div>
      <div v-if="courseEvents" class="flex-fe">
        <router-link :to="{name: 'courses'}">
          <span>Alle anzeigen</span>
        </router-link>
      </div>
    </div>
  </div>
</template>
<script>
// Icons
import { ArrowUpRightIcon } from "vue-feather-icons";

// Mixins
import Helpers from "@/global/mixins/Helpers";

// Components
import CourseEventsList from "@/global/components/CourseEventsList";

export default {
  components: {
    ArrowUpRightIcon,
    CourseEventsList
  },

  mixins: [Helpers],

  data() {
    return {
      tutor: {},
      courseEvents: {},
      isFetched: false
    };
  },

  created() {
    this.fetch();
  },

  methods: {
    fetch() {
      this.axios.get(`/api/tutor/course/events/upcoming`).then(response => {
        this.tutor = response.data.tutor;
        this.courseEvents = response.data.courseEvents;
        this.isFetched = true;
      });
    }
  }
};
</script>