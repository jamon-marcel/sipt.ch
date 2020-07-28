<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <div :class="isFetchedCoursesBooked ? 'is-loaded' : 'is-loading'">
      <header class="content-header">
        <div v-html="title">{{title}}</div>
      </header>

      <div class="overlay is-visible" v-if="hasOverlay">
        <div class="overlay__inner">
          <div>
            <a href @click.prevent="hidePenaltyConfirmation()" class="feather-icon">
              <x-icon size="24"></x-icon>
            </a>
            <h2>Bitte Kosten bestätigen</h2>
            <p>Für Ihre Annullation müssen wir Ihnen leider <strong>{{cancellationPenalty}}%</strong> der Modulkosten in Rechnung stellen.</p>
            <div class="flex sb-sm">
              <button class="btn-primary is-sm" @click.prevent="confirmPenalty()">Bestätigen</button>
              &nbsp;&nbsp;
              <button class="btn-secondary is-sm" @click.prevent="hidePenaltyConfirmation()">Abbrechen</button>
            </div>
          </div>
        </div>
      </div>

      <div class="content">
        <p>Eine Übersicht Ihrer bevorstehenden und absolvierten Module.</p>
        <template v-if="isFetchedCoursesBooked">
          <h2>Bevorstehende Module</h2>
          <course-events-list
            :records="courses.booked"
            :hasDetail="true"
            v-if="courses.booked.length"
          ></course-events-list>
          <div class="no-records" v-else>Es sind keine Module vorhanden...</div>
          <course-event-register :records="courses.booked"></course-event-register>
        </template>
        <template v-if="isFetchedCoursesAttended">
          <h2>Absolvierte Module</h2>
          <div class="listing" v-if="courses.attended.length">
            <div class="listing__item" v-for="r in courses.attended" :key="r.id">
              <div class="listing__item-body">
                <span class="item-date">{{r.dates}}</span>
                <separator />
                {{ r.title }}
                <separator />
                {{ r.tutors }}
              </div>
              <div class="listing__item-action">
                <a :href="'/download/modulbestaetigung/' + r.id" class="feather-icon" target="_blank" title="Modulbestätigung herunterladen">
                  <download-cloud-icon size="20"></download-cloud-icon>
                </a>
              </div>
            </div>
          </div>
          <div class="no-records" v-else>Es sind keine Module vorhanden...</div>
        </template>
        <div class="sb-md">
          <a href class="feather-icon feather-icon--prepend is-highlight">
            <award-icon size="16"></award-icon>
            <span>Ausbildungsblatt herunterladen</span>
          </a>
        </div>
      </div>
      <footer class="module-footer">
        <div>
          <router-link :to="{ name: 'home' }" class="btn-secondary">
            <span>Zurück</span>
          </router-link>
        </div>
      </footer>
    </div>
  </div>
</template>
<script>

// Icons
import { AwardIcon, XIcon, DownloadCloudIcon } from "vue-feather-icons";

// Mixins
import Helpers from "@/global/mixins/Helpers";
import DateTime from "@/global/mixins/DateTime";

// Components
import CourseEventsList from "@/global/components/CourseEventsList";
import CourseEventRegister from "@/global/components/CourseEventRegister";

export default {
  components: {
    CourseEventsList,
    CourseEventRegister,
    AwardIcon,
    DownloadCloudIcon,
    XIcon
  },

  mixins: [Helpers, DateTime],

  data() {
    return {
      courses: {
        booked: {},
        attended: {}
      },
      isFetched: false,
      isFetchedCoursesBooked: false,
      isFetchedCoursesAttended: false,
      isLoading: false,
      hasOverlay: false,

      cancellationId: false,
      cancellationPenalty: 0,
    };
  },

  created() {
    this.fetch();
  },

  methods: {
    fetch() {
      // Get booked courses
      this.axios.get(`/api/student/course/events/booked`).then(response => {
        this.courses.booked = response.data.courseEvents.map(x => ({
          title: x.course.title,
          dates: this.datesToString(x.dates),
          tutors: this.tutorsToString(x.dates),
          cancelPenalty: this.getCancelPenalty(x.dates),
          id: x.id
        }));
        this.isFetchedCoursesBooked = true;
      });

      // Get attended courses
      this.axios.get(`/api/student/course/events/attended`).then(response => {
        this.courses.attended = response.data.courseEvents.map(x => ({
          title: x.course.title,
          dates: this.datesToString(x.dates),
          tutors: this.tutorsToString(x.dates),
          id: x.id
        }));
        this.isFetchedCoursesAttended = true;
      });
    },

    destroy(id) {
      if (confirm("Bitte löschen bestätigen!")) {
        let courses = this.courses.booked, 
            idx = courses.findIndex(x => x.id === id);

        // Show message if cancellaction fee occurs
        if (idx !== -1 && courses[idx].cancelPenalty > 0) {
          this.showPenaltyConfirmation(id, courses[idx].cancelPenalty);
        }
        else {
          this.cancel(id);
        }
      }
    },

    cancel(id) {
      let uri = `/api/student/course/event/${id}`;
      this.isLoading = true;
      this.axios.delete(uri).then(response => {
        this.fetch();
        this.$notify({ type: "success", text: "Buchung annuliert!" });
        this.isLoading = false;
      });
    },

    showPenaltyConfirmation(id, penalty) {
      this.hasOverlay = true;
      this.cancellationId = id;
      this.cancellationPenalty = penalty;
    },

    hidePenaltyConfirmation() {
      this.cancellationId = false;
      this.hasOverlay = false;
      this.cancellationPenalty = 0;
    },

    confirmPenalty() {
      this.cancel(this.cancellationId);
      this.hidePenaltyConfirmation();
    },

    getCancelPenalty(data) {
      let date = data.map(x => x.date).shift(), 
          diff = this.dateDifferenceFromNow(date),
          penalty = 0;

      if (diff < 14) {
        return 100;
      }
      else if (diff < 28) {
        return 50;
      }
      else if (diff < 56) {
        return 25;
      }
      return 0;
    }
  },

  computed: {
    title: function() {
      return "<h1>Ihre Module</h1>";
    }
  }
};
</script>