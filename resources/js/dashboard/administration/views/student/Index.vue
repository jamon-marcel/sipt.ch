<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <div :class="isFetched ? 'is-loaded' : 'is-loading'">
      <header class="content-header flex-sb flex-vc">
        <h1>Studenten</h1>
        <div style="width: 320px">
          <input type="text" placeholder="Suche nach Name, Vorname, Kundennummer" v-model="search">
        </div>
      </header>
      <div class="listing" v-if="students.length">
        <div
          :class="[s.is_published == 0 ? 'is-disabled' : '', 'listing__item']"
          v-for="s in studentsList"
          :key="s.id"
        >
          <div class="listing__item-body">
            {{ s.number}}
            <separator/>
            {{ s.name}}
            <separator/>
            {{s.firstname }}
            <separator/>
            <em v-if="s.title">
              {{ s.title }}
              <separator/>
            </em>
            {{ s.city }}
            <span class="bubble-info" v-if="s.is_active == 0">Inaktiv</span>
          </div>
          <list-actions
            :id="s.id"
            :hasToggle="false"
            :hasDestroy="true"
            :hasEdit="true"
            :hasShow="true"
            :hasEvent="true"
            :record="s"
            :routes="{show: 'student-profile', events: 'student-courses', edit: 'student-profile-edit'}"
          ></list-actions>
        </div>
      </div>
      <div v-else>
        <p class="no-records">Es sind noch keine Studenten vorhanden...</p>
      </div>
      <footer class="module-footer">
        <div class="flex-sb flex-vc">
          <a :href="'/export/adressliste?v=' + randomString()" class="btn-primary has-icon" target="_blank">
            <download-icon size="16"></download-icon>
            <span>Adressliste</span>
          </a>
        </div>
      </footer>
    </div>
  </div>
</template>
<script>
// Icons
import { PlusIcon, DownloadIcon } from "vue-feather-icons";

// Mixins
import Helpers from "@/global/mixins/Helpers";
import DateTime from "@/global/mixins/DateTime";
import ErrorHandling from "@/global/mixins/ErrorHandling";

// Components
import ListActions from "@/global/components/ui/ListActions.vue";

export default {
  components: {
    ListActions,
    DownloadIcon
  },

  mixins: [Helpers, DateTime, ErrorHandling],

  data() {
    return {
      isFetched: false,
      isLoading: false,
      search: "",
      students: []
    };
  },

  created() {
    this.fetch();
  },

  methods: {
    fetch() {
      this.isLoading = true;
      this.axios.get(`/api/students`).then(response => {
        this.students = response.data.data;
        this.isFetched = true;
        this.isLoading = false;
      });
    },

    destroy(id, event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/student/${id}`;
        this.axios.delete(uri).then(response => {
          this.fetch();
        });
      }
    }
  },
  computed: {
    studentsList() {
      return this.students.filter(student => {
        let name = student.name,
          firstname = student.firstname,
          number = student.number;
        if (
          name.toLowerCase().includes(this.search.toLowerCase()) ||
          firstname.toLowerCase().includes(this.search.toLowerCase()) ||
          number == this.search
        ) {
          return student;
        }
      });
    }
  }
};
</script>