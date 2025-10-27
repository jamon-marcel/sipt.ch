<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <div :class="isFetched ? 'is-loaded' : 'is-loading'">
      <header class="content-header">
        <h1>SIPT zertifizierte Therapeut:innen</h1>
      </header>

      <!-- Intro Text Record -->
      <h2>Intro</h2>
      <div v-if="intro" class="listing__item" :class="[intro.is_published == 0 ? 'is-disabled' : '']">
        <div class="listing__item-body">
          <div v-html="intro.content"></div>
        </div>
        <div class="listing__item-action">
          <div>
            <a
              href="javascript:;"
              @click.prevent="toggleIntro($event)"
            >
              <span v-if="intro.is_published" class="feather-icon">
                <eye-icon size="18"></eye-icon>
              </span>
              <span v-else>
                <eye-off-icon size="18" class="feather-icon"></eye-off-icon>
              </span>
            </a>
          </div>
          <div>
            <router-link
              :to="{name: 'therapist-intro-edit'}"
              class="feather-icon"
            >
              <edit-icon size="18"></edit-icon>
            </router-link>
          </div>
        </div>
      </div>
      <br>
      <div v-if="therapists.length">
        <h2>Schweiz</h2>
        <draggable
          v-model="switzerlandTherapists"
          group="therapists"
          handle=".drag-handle"
          :element="'div'"
          @end="onDragEnd"
        >
          <div
            v-for="therapist in switzerlandTherapists"
            :key="therapist.id"
            :class="[therapist.is_published == 0 ? 'is-disabled' : '', 'listing__item']">
            <div class="listing__item-body is-draggable">
              <div class="drag-handle">
                <move-icon size="16"></move-icon>
              </div>
              <div>
                <strong>{{ therapist.title ? therapist.title + ' ' : '' }}{{ therapist.name }}, {{ therapist.firstname }} </strong>
              </div>
            </div>
            <list-actions
              :id="therapist.id"
              :record="therapist"
              :hasDestroy="true"
              :hasToggle="true"
              :isDraggable="true"
              :routes="{edit: 'therapist-edit'}">
            </list-actions>
          </div>
        </draggable>
        <br>
        <h2>Deutschland</h2>
        <draggable
          v-model="germanyTherapists"
          group="therapists"
          handle=".drag-handle"
          :element="'div'"
          @end="onDragEnd"
        >
          <div
            v-for="therapist in germanyTherapists"
            :key="therapist.id"
            :class="[therapist.is_published == 0 ? 'is-disabled' : '', 'listing__item']">
            <div class="listing__item-body is-draggable">
              <div class="drag-handle">
                <move-icon size="16"></move-icon>
              </div>
              <div>
                <strong>{{ therapist.title ? therapist.title + ' ' : '' }}{{ therapist.name }}, {{ therapist.firstname }}</strong>
              </div>
            </div>
            <list-actions
              :id="therapist.id"
              :record="therapist"
              :hasDestroy="true"
              :hasToggle="true"
              :isDraggable="true"
              :routes="{edit: 'therapist-edit'}">
            </list-actions>
          </div>
        </draggable>
      </div>

      <div v-else>
        <p class="no-records">Es sind noch keine Einträge vorhanden...</p>
      </div>

      <footer class="module-footer">
        <div>
          <router-link :to="{ name: 'therapist-create' }" class="btn-primary has-icon">
            <plus-icon size="16"></plus-icon>
            <span>Hinzufügen</span>
          </router-link>
        </div>
      </footer>
    </div>
  </div>
</template>

<script>
// Vue draggable
import draggable from 'vuedraggable';

// Icons
import { PlusIcon, MoveIcon, EyeIcon, EyeOffIcon, EditIcon } from 'vue-feather-icons';

// Components
import ListActions from "@/global/components/ui/ListActions.vue";
import Separator from "@/global/components/ui/Separator.vue";

export default {
  components: {
    ListActions,
    PlusIcon,
    MoveIcon,
    EyeIcon,
    EyeOffIcon,
    EditIcon,
    draggable,
    Separator,
  },

  data() {
    return {
      isLoading: false,
      isFetched: false,
      therapists: [],
      intro: null,
    };
  },

  created() {
    this.fetchIntro();
    this.fetch();
  },

  computed: {
    germanyTherapists: {
      get() {
        return this.therapists.filter(t => t.country === 'Germany');
      },
      set(value) {
        // Update the therapists array with the new order for Germany therapists
        const switzerlandTherapists = this.therapists.filter(t => t.country === 'Switzerland');
        this.therapists = [...value, ...switzerlandTherapists];
      }
    },
    switzerlandTherapists: {
      get() {
        return this.therapists.filter(t => t.country === 'Switzerland');
      },
      set(value) {
        // Update the therapists array with the new order for Switzerland therapists
        const germanyTherapists = this.therapists.filter(t => t.country === 'Germany');
        this.therapists = [...germanyTherapists, ...value];
      }
    }
  },

  methods: {
    fetchIntro() {
      this.axios.get(`/api/therapist-intro`).then(response => {
        this.intro = response.data;
      });
    },

    fetch() {
      this.axios.get(`/api/therapists`).then(response => {
        this.therapists = response.data.data;
        this.isFetched = true;
      });
    },

    updateIntro() {
      this.axios.put(`/api/therapist-intro`, this.intro).then(() => {
        this.$notify({ type: "success", text: "Einführungstext gespeichert" });
      });
    },

    toggleIntro() {
      const uri = `/api/therapist-intro/state`;
      this.isLoading = true;
      this.axios.get(uri).then(response => {
        if (this.intro) {
          this.intro.is_published = response.data;
        }
        this.$notify({ type: "success", text: "Status geändert" });
        this.isLoading = false;
      });
    },

    toggle(id, event) {
      const uri = `/api/therapist/state/${id}`;
      this.isLoading = true;
      this.axios.get(uri).then(response => {
        const index = this.therapists.findIndex(x => x.id === id);
        if (index !== -1) {
          this.therapists[index].is_published = response.data;
        }
        this.$notify({ type: "success", text: "Status geändert" });
        this.isLoading = false;
      });
    },

    destroy(id, event) {
      if (confirm("Bitte löschen bestätigen!")) {
        const uri = `/api/therapist/${id}`;
        this.isLoading = true;
        this.axios.delete(uri).then(() => {
          this.fetch();
          this.isLoading = false;
        });
      }
    },

    onDragEnd() {
      const reorderedIds = this.therapists.map(t => t.id);
      this.axios.put(`/api/therapists/order`, { ids: reorderedIds })
      .then(() => {
        this.$notify({ type: "success", text: "Reihenfolge gespeichert" });
      })
      .catch(() => {
        this.$notify({ type: "error", text: "Fehler beim Speichern der Reihenfolge" });
      });
    }
  }
};
</script>
