<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <div v-if="hasMessageOverlay">
      <show-message :messageId="messageId"></show-message>
    </div>
    <div class="content">
      <template v-if="isFetched">
        <h1>Modul: <strong>{{ course_event.course.title }}</strong></h1>
        <h2 class="is-narrow">Beschreibung</h2>
        <p v-html="course_event.course.description">{{ course_event.course.description }}</p>
        <hr>
        <h2 class="is-narrow">Ort</h2>
        <p>
          {{ course_event.location.name }}, {{ course_event.location.city }} – <a :href="course_event.location.maps_uri" target="_blank" class="anchor">Googlemaps</a></p>
        <hr>
        <h2 class="is-narrow">Credits</h2>
        <p>{{ course_event.course.credits }}</p>
        <hr>
        <h2 class="is-narrow">Kosten</h2>
        <p>CHF {{ course_event.course.cost }}</p>
        <hr>
        <h2 class="is-narrow">Daten</h2>
        <div class="listing">
          <div class="listing__item" v-for="date in course_event.dates" :key="date.id">
            <div class="listing__item-body">
              {{date.date}} <separator />
              {{date.timeStart}} –  {{date.timeEnd}} Uhr <separator />
              {{date.tutor.title}} {{date.tutor.firstname}} {{date.tutor.name}}
            </div>
          </div>
        </div>
        <div v-if="course_event.documents.length">
          <h2 class="is-narrow">Unterlagen</h2>
          <p>Ihre Dozenten haben folgende Unterlagen zur Verfügung gestellt:</p>
          <div class="listing">
            <div class="listing__item" v-for="d in course_event.documents" :key="d.id">
              <div class="listing__item-body">
                <a
                  :href="'/storage/uploads/'+ d.name"
                  target="_blank"
                >
                  <em v-if="d.caption != d.name">{{ d.caption | truncate(30, '...') }}</em> 
                  <em v-else>{{ d.name | truncate(30, '...') }}</em>
                </a>
                <separator />
                <span class="item-info">{{d.type.toUpperCase()}}, {{d.size}}</span>
              </div>
              <div class="listing__item-action">
                <div>
                  <a
                    :href="'/storage/uploads/'+ d.name"
                    target="_blank"
                    class="feather-icon"
                  >
                    <download-cloud-icon size="18"></download-cloud-icon>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>
      <div class="sb-md">
        <div class="flex-sb">
          <h2 class="is-narrow">Nachrichten</h2>
        </div>
        <template v-if="isFetchedMessages">
          <div v-if="messages.length">
            <div class="sb-xs listing">
              <div
                class="listing__item"
                v-for="message in messages"
                :key="message.id"
              >
                <div class="listing__item-body">
                  <a href="" @click.prevent="showMessage(message.id)">
                    {{message.date}}
                    <separator />
                    {{message.senderName}}
                    <separator />
                    {{message.subject}}
                  </a>
                </div>
                <div class="listing__item-action">
                  <div>
                    <a
                      href="javascript:;"
                      @click.prevent="showMessage(message.id)"
                      class="feather-icon"
                    >
                      <arrow-up-right-icon size="18"></arrow-up-right-icon>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div v-else>
            <p class="no-records">Es haben sich noch keine Nachrichten vorhanden...</p>
          </div>
        </template>
      </div>
    </div>
    <footer class="module-footer">
      <div>
        <a href="javascript:history.go(-1)" class="btn-secondary">
          <span>Zurück</span>
        </a>
      </div>
    </footer>
  </div>
</template>
<script>

// Icons
import { UsersIcon, DownloadCloudIcon, ArrowUpRightIcon } from 'vue-feather-icons';

// Mixins
import Helpers from "@/global/mixins/Helpers";

// Components
import ShowMessage from "@/global/components/ShowMessage.vue";

export default {

  components: {
    UsersIcon,
    DownloadCloudIcon,
    ArrowUpRightIcon,
    ShowMessage
  },

  props: {

    id: {
      type: String,
      default: null,
    },

  },

  mixins: [Helpers],

  data() {
    return {
      isLoading: false,
      isFetched: false,
      isFetchedMessages: false,
      hasMessageOverlay: false,
      course_event: {},
      messages: [],
      messageId: null,
    };
  },

  mounted() {
    this.fetch();
  },

  methods: {
    fetch() {
      this.isLoading = true;
      this.axios.get(`/api/student/course/event/${this.$props.id}`).then(response => {
        this.course_event = response.data;
        this.isFetched = true;
        this.isLoading = false;
      });

      // Get messages
      this.axios.get(`/api/messages/${this.$props.id}`).then(response => {
        this.messages = response.data;
        this.isFetchedMessages = true;
      });
    },

    showMessage(id) {
      this.messageId = id;
      this.hasMessageOverlay = true;
    },

    hideMessage() {
      this.hasMessageOverlay = false;
    },

  }
}
</script>
