<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  <div :class="isFetchedConcluded && isFetchedClosed && isFetchedAll ? 'is-loaded' : 'is-loading'">
    <div class="sa-md">
      <header class="content-header flex-sb flex-vc">
        <h1>Beendete Module</h1>
        <view-selector
          :items="[
            {route: '/administration/backoffice/modules', label: 'Module'},
            {route: '/administration/backoffice/invoices', label: 'Rechnungen'},
          ]"
        ></view-selector>
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
        <p class="no-records">Zur Zeit sind keine Module vorhanden...</p>
      </div>
    </div>
    <div>
      <header class="content-header flex-sb flex-vc">
        <h1>Geschlossene Module</h1>
        <a href="" class="feather-icon feather-icon--prepend" @click.prevent="toggleClosed()">
          <chevron-down-icon size="20"></chevron-down-icon>
          <span>Anzeigen</span>
        </a>
      </header>
      <div v-if="showClosed">
        <div class="listing is-grouped" v-if="coursesClosed.length">
          <div
            :class="[c.is_published == 0 ? 'is-disabled' : '', '']"
            v-for="c in coursesClosed"
            :key="c.id"
          >
            <div class="listing-group">
              <h2>{{ c.number }} – {{ c.title }}</h2>
              <div v-if="c.events_closed.length">
                <div class="listing__item is-group" v-for="e in c.events_closed" :key="e.id">
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
      </div>
    </div>
  </div>
</div>
</template>
<script>

// Icons
import { PlusIcon, DownloadIcon, ChevronDownIcon } from 'vue-feather-icons';

// Components
import ListActions from "@/global/components/ui/ListActions.vue";
import ViewSelector from '@/administration/components/ViewSelector.vue';

// Mixins
import Helpers from "@/global/mixins/Helpers";
import DateTime from "@/global/mixins/DateTime";
import ErrorHandling from "@/global/mixins/ErrorHandling";

export default {

  components: {
    ListActions,
    PlusIcon,
    DownloadIcon,
    ChevronDownIcon,
    ViewSelector
  },

  mixins: [Helpers, DateTime, ErrorHandling],

  data() {
    return {
      courses: [],
      course_event: null,
      course_event_id: null,
      courses_concluded: [],
      courses_closed: [],
      isLoading: false,
      isFetchedConcluded: false,
      isFetchedClosed: false,
      isFetchedAll: false,
      isFetchedCourse: false,
      showClosed: false,
    };
  },

  created() {
    this.fetch();
  },

  methods: {

    fetch() {
      this.axios.get(`/api/backoffice/courses/list/concluded`).then(response => {
        this.courses_concluded = response.data.data;
        this.isFetchedConcluded = true;
      });

      this.axios.get(`/api/backoffice/courses/list/closed`).then(response => {
        this.courses_closed = response.data.data;
        this.isFetchedClosed = true;
      });

      this.axios.get(`/api/courses`).then(response => {
        this.courses = response.data.data;
        this.isFetchedAll = true;
      });
    },

    toggleClosed() {
      this.showClosed = this.showClosed ? false : true;
    },

    getCourse(course) {
      this.isFetchedCourse = false;
      this.axios.get(`/api/course/event/${course}`).then(response => {
        this.course_event = response.data;
        this.isFetchedCourse = true;
      });
    }

  },

  computed: {
    coursesConcluded() {
      let courses = this.courses_concluded.filter(function(course) {
        return course.events_completed.length;
      });
      return courses;
    },

    coursesClosed() {
      let courses = this.courses_closed.filter(function(course) {
        return course.events_closed.length;
      });
      return courses;
    },
  }
}
</script>