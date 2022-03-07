<template>
  <div>
    <div v-if="hasOverlay">
      <add-event></add-event>
    </div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <form @submit.prevent="submit" :class="isFetched ? 'is-loaded' : 'is-loading'">
      <header class="content-header">
        <h1>Modul: <strong>{{course.title}}</strong> – {{courseDates}}</h1>
      </header>
      <div class="grid-main-sidebar">
        <div>
          <template v-if="isFetched">
            <div :class="this.errors.location_id ? 'has-error' : ''">
              <location-selector
                v-bind:location_id.sync="course_event.location_id"
                :label="'Kursort'"
                :model="course_event.location_id"
                :name="'location_id'"
                :required="true"
              ></location-selector>
            </div>
            <div :class="[this.errors.max_participants ? 'has-error' : '', 'form-row']">
              <label>max. Teilnehmer *</label>
              <input type="text" v-model="course_event.max_participants">
              <label-required />
            </div>
            <label class="flex-sb sb-lg">
              <span :class="this.errors.dates ? 'has-error' : ''">Daten</span>
              <a href @click.prevent="toggleOverlay()" class="feather-icon feather-icon--prepend">
                <plus-icon size="16"></plus-icon>
                <span>Hinzufügen</span>
              </a>
            </label>
            <div class="listing" v-if="course_event.dates.length">
              <div
                class="listing__item is-narrow"
                v-for="c in course_event.dates"
                :key="c.id"
                data-icons="1"
              >
                <div class="listing__item-body">
                  {{ c.date }}
                  <separator />
                  {{ c.timeStart }} - {{ c.timeEnd }} Uhr
                  <separator />
                  {{ getTutorName(c.tutor_id) }}
                </div>
                <div class="listing__item-action" data-icons="1">
                  <a href="javascript:;" class="feather-icon" @click.prevent="destroyEventDate(c)">
                    <trash2-icon size="18"></trash2-icon>
                  </a>
                </div>
              </div>
            </div>
            <div v-else>
              <p class="no-records">Es sind noch keine Daten für dieses Modul erfasst...</p>
            </div>
          </template>
        </div>
        <div class="grid-column-sidebar">
          <div>
            <template v-if="isFetched">
              <div class="form-row is-sm">
                <radio-button
                  :label="'Online Kurs?'"
                  v-bind:is_online.sync="course_event.is_online"
                  :model="course_event.is_online"
                  :name="'is_online'"
                ></radio-button>
              </div>
              <div class="form-row is-sm">
                <radio-button
                  :label="'Publizieren?'"
                  v-bind:is_published.sync="course_event.is_published"
                  :model="course_event.is_published"
                  :name="'is_published'"
                ></radio-button>
              </div>
              <div class="form-row is-sm">
                <radio-button
                  :label="'Registration möglich?'"
                  v-bind:is_bookable.sync="course_event.is_bookable"
                  :model="course_event.is_bookable"
                  :name="'is_bookable'"
                ></radio-button>
              </div>
              <div class="form-row is-sm is-last">
                <radio-button
                  :label="'Abgesagt?'"
                  v-bind:is_cancelled.sync="course_event.is_cancelled"
                  :model="course_event.is_cancelled"
                  :name="'is_cancelled'"
                ></radio-button>
                <div class="form-info is-danger">
                  <strong>Achtung:</strong><br>wird eine Veranstaltung abgesagt, werden sämtliche Teilnehmer und Dozenten autom. per E-Mail benachrichtigt!
                </div>
              </div>
            </template>
          </div>
        </div>
      </div>
      <footer class="module-footer">
        <div>
          <button type="submit" class="btn-primary">Speichern</button>
          <router-link :to="{ name: 'course-events', params: { id: course.id } }" class="btn-secondary">
            <span>Zurück</span>
          </router-link>
        </div>
      </footer>
    </form>
  </div>
</template>
<script>
// Icons
import { ArrowLeftIcon, PlusIcon, Trash2Icon } from "vue-feather-icons";

// Mixins
import ErrorHandling from "@/global/mixins/ErrorHandling";
import DateTime from "@/global/mixins/DateTime";
import Helpers from "@/global/mixins/Helpers";


// TinyMCE
import tinyConfig from "@/global/config/tiny.js";
import TinymceEditor from "@tinymce/tinymce-vue";

// Components
import RadioButton from "@/global/components/ui/RadioButton.vue";
import LabelRequired from "@/global/components/ui/LabelRequired.vue";
import LocationSelector from "@/administration/components/LocationSelector.vue";
import AddEvent from "@/administration/views/course_events/AddEvent.vue";

export default {
  components: {
    ArrowLeftIcon,
    PlusIcon,
    Trash2Icon,
    TinymceEditor,
    RadioButton,
    LabelRequired,
    LocationSelector,
    AddEvent
  },

  mixins: [DateTime, Helpers, ErrorHandling],

  props: {
    type: String
  },

  data() {
    return {
      // Model
      course: {
        id: null,
        title: null
      },

      course_event: {
        course_id: null,
        location_id: '76ab6fee-bb20-4d36-b456-a1d606e45c78',
        max_participants: 1,
        is_online: 0,
        is_cancelled: 0,
        is_published: 1,
        dates: []
      },

      // Validation
      errors: {
        location_id: false,
        max_participants: false,
        dates: false,
      },

      // Tutors
      tutors: [],

      // Lazy loading
      isFetched: true,
      isLoading: false,

      // Overlay
      hasOverlay: false
    };
  },

  created() {
    this.fetch();
  },

  methods: {
    fetch() {
      this.isFetched = false;

      if (this.$props.type == "create") {
        this.axios
          .get(`/api/course/${this.$route.params.id}`)
          .then(response => {
            this.course = response.data;
            this.course_event.course_id = this.course.id;
            this.axios.get(`/api/tutors/active`).then(response => {
              this.tutors = response.data.data;
              this.isFetched = true;
            });
          });
      }

      if (this.$props.type == "edit") {
        this.axios
          .get(`/api/course/event/${this.$route.params.id}`)
          .then(response => {
            this.course_event = response.data;
            this.course = this.course_event.course;
            this.axios.get(`/api/tutors/active`).then(response => {
              this.tutors = response.data.data;
              this.isFetched = true;
            });
          }
        );
      }
    },

    // Submit form
    submit() {
      if (this.$props.type == "edit") {
        this.update();
      }

      if (this.$props.type == "create") {
        this.store();
      }
    },

    store() {
      let uri = "/api/course/event";
      this.axios.post(uri, this.course_event).then(response => {
        this.$router.push({
          name: "course-events",
          params: { id: this.course.id }
        });
        this.$notify({ type: "success", text: "Modul Daten erfasst!" });
      });
    },

    update() {
      let uri = `/api/course/event/${this.$route.params.id}`;
      this.isLoading = true;
      this.axios.put(uri, this.course_event).then(response => {
        this.$router.push({
          name: "course-events",
          params: { id: this.course.id }
        });
        this.isLoading = false;
        this.$notify({ type: "success", text: "Änderungen gespeichert!" });
      });
    },

    storeEventDate(data) {
      this.course_event.dates.push(data);
    },

    destroyEventDate(data) {
      if (confirm("Bitte löschen bestätigen!")) {
        if (data.id === null) {
          const index = this.course_event.dates.findIndex(
            x =>
              x.date == data.date &&
              x.timeStart == data.timeStart &&
              x.timeEnd == data.timeEnd
          );
          this.course_event.dates.splice(index, 1);
        } 
        else {
          let uri = `/api/course/event/date/${data.id}`;
          this.axios.delete(uri).then(response => {
            const index = this.course_event.dates.findIndex(
              x => x.id == data.id
            );
            this.course_event.dates.splice(index, 1);
          });
        }
      }
    },

    toggleOverlay() {
      this.hasOverlay = this.hasOverlay ? false : true;
    },

    getTutorName(id) {
      const index = this.tutors.findIndex(x => x.id === id);
      console.log(index);
      return this.tutors[index].firstname + " " + this.tutors[index].name;
    }
  },

  computed: {
    courseDates() {
      return this.datesToString(this.course_event.dates);
    }
  }
};
</script>
