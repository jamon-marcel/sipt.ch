<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <header class="content-header flex-sb flex-vc">
      <h1>Vergangene Module</h1>
      <view-selector></view-selector>
    </header>
    <div class="listing is-grouped" v-if="coursesConcluded.length">
      <div
        :class="[c.is_published == 0 ? 'is-disabled' : '', '']"
        v-for="c in coursesConcluded"
        :key="c.id"
      >
        <div class="listing-group">
          <h2>{{ c.number }} – {{ c.title }}</h2>
          <div v-if="c.events_completed.length">
            <div class="listing__item is-group" v-for="e in c.events_completed" :key="e.id">
              <div class="listing__item-body">
                <span>{{ c.number }}.{{dateFormat(e.dateStart, 'DDMMYY')}}</span>
                <separator />
                <span>{{ datesToString(e.dates) }}</span>
                <separator />
                <span>{{ tutorsToString(e.dates) }}</span>
              </div>
              <list-actions
                :id="e.id" 
                :record="c"
                :hasDetail="true"
                :hasEdit="false"
                :hasDestroy="false"
                :hasToggle="false"
                :routes="{details: 'backoffice-course-event'}">
              </list-actions>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else>
      <p>Es sind noch keine Module vorhanden...</p>
    </div>
    <footer class="module-footer">
      <div>
        <a href="/download/modulliste" class="btn-primary has-icon" target="_blank">
          <span>Download Modulliste</span>
        </a>
      </div>
    </footer>
  </div>
</div>
</template>
<script>

// Icons
import { PlusIcon, DownloadIcon } from 'vue-feather-icons';

// Components
import ListActions from "@/global/components/ui/ListActions.vue";
import ViewSelector from '@/administration/views/backoffice/components/ViewSelector.vue';

// Mixins
import Helpers from "@/global/mixins/Helpers";
import DateTime from "@/global/mixins/DateTime";
import ErrorHandling from "@/global/mixins/ErrorHandling";

export default {

  components: {
    ListActions,
    PlusIcon,
    DownloadIcon,
    ViewSelector
  },

  mixins: [Helpers, DateTime, ErrorHandling],

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
      this.axios.get(`/api/backoffice/courses/list/concluded`).then(response => {
        this.courses = response.data.data;
        this.isFetched = true;
      });
    },

  },

  computed: {
    coursesConcluded() {
      let courses = this.courses.filter(function(course) {
        return course.events_completed.length;
      });
      return courses;
    }
  }
}
</script>