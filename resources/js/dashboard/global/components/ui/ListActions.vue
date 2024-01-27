<template>
  <div class="listing__item-action">

    <div v-if="hasMailingQueue">
      <router-link
        :to="{name: routes.queue, params: { id: id }}"
        class="feather-icon"
      >
        <users-icon size="18"></users-icon>
      </router-link>
    </div>

    <div v-if="hasMailingActivate">
      <a href="" 
        class="feather-icon" 
        title="Versand starten"
        @click.prevent="$emit('activate', $event)">
        <mail-icon size="18"></mail-icon>
      </a>
    </div>

    <div v-if="hasInvitation">
      <span v-if="student">
        <a :href="routes.invitation + '/' + student" target="_blank" class="feather-icon" title="Kurseinladung herunterladen">
          <download-cloud-icon size="18"></download-cloud-icon>
        </a>
      </span>
      <span v-else>
        <a :href="routes.invitation" target="_blank" class="feather-icon" title="Kurseinladung herunterladen">
          <download-cloud-icon size="18"></download-cloud-icon>
        </a>
      </span>
    </div>

    <div v-if="hasAttendance">
      <span v-if="student">
        <a :href="routes.attendance + '/' + student" target="_blank" class="feather-icon" title="Kursbestätigung herunterladen">
          <download-cloud-icon size="18"></download-cloud-icon>
        </a>
      </span>
      <span v-else>
        <a :href="routes.attendance" target="_blank" class="feather-icon" title="Kursbestätigung herunterladen">
          <download-cloud-icon size="18"></download-cloud-icon>
        </a>
      </span>
    </div>

    <div v-if="hasDownload">
      <a :href="routes.download" target="_blank"
        class="feather-icon"
      >
        <download-cloud-icon size="18"></download-cloud-icon>
      </a>   
    </div>

    <div v-if="hasDetail">
      <router-link
        :to="{name: routes.details, params: { id: id }}"
        class="feather-icon"
      >
        <arrow-up-right-icon size="18"></arrow-up-right-icon>
      </router-link>
    </div>

    <div v-if="hasToggle">
      <a
        href="javascript:;"
        @click.prevent="toggle(id,$event)"
      >
        <span v-if="record.is_published" class="feather-icon">
          <eye-icon size="18"></eye-icon>
        </span>
        <span v-else>
          <eye-off-icon size="18" class="feather-icon"></eye-off-icon>
        </span>
      </a>
    </div>

    <div v-if="hasEvent">
      <router-link
        :to="{name: routes.events, params: { id: id }}"
        class="feather-icon"
      >
        <em v-if="eventCount > 0">{{eventCount}}</em>
        <calendar-icon size="18"></calendar-icon>
      </router-link>
    </div>

    <div v-if="hasEdit">
      <router-link
        :to="{name: routes.edit, params: { id: id }}"
        class="feather-icon"
      >
        <edit-icon size="18"></edit-icon>
      </router-link>
    </div>

    <div v-if="hasShow">
      <router-link
        :to="{name: routes.show, params: { id: id }}"
        class="feather-icon"
      >
        <user-icon size="18"></user-icon>
      </router-link>
    </div>
    
    <div v-if="hasDestroy">
      <a
        href="javascript:;"
        class="feather-icon"
        @click.prevent="destroy(id,$event)"
      >
        <trash2-icon size="18"></trash2-icon>
      </a>
    </div>

  </div>
</template>
<script>

// Icons
import { 
  EyeIcon,
  EyeOffIcon,
  EditIcon,
  Trash2Icon,
  CalendarIcon,
  UserIcon,
  ArrowUpRightIcon,
  DownloadCloudIcon,
  MailIcon,
  UsersIcon
} from 'vue-feather-icons';

export default {

  components: {
    EyeIcon,
    EyeOffIcon,
    EditIcon,
    Trash2Icon,
    CalendarIcon,
    UserIcon,
    ArrowUpRightIcon,
    DownloadCloudIcon,
    MailIcon,
    UsersIcon
  },

  props: {

    id: {
      type: String,
      default: null
    },

    eventCount: {
      type: Number,
      default: 0,
    },
    
    hasDownload: {
      type: Boolean,
      default: false,
    },

    hasEdit: {
      type: Boolean,
      default: true
    },
    
    hasDestroy: {
      type: Boolean,
      default: true
    },
    
    hasToggle: {
      type: Boolean,
      default: true
    },

    hasEvent: {
      type: Boolean,
      default: false
    },

    hasShow: {
      type: Boolean,
      default: false,
    },
    
    hasDetail: {
      type: Boolean,
      default: false,
    },

    hasInvitation: {
      type: Boolean,
      default: false,
    },

    hasAttendance: {
      type: Boolean,
      default: false,
    },

    hasMailingActivate: {
      type: Boolean,
      default: false,
    },

    hasMailingQueue: {
      type: Boolean,
      default: false,
    },

    studentId: null,

    routes: Object,
    record: Object,
  },

  methods: {

    toggle(id,$event) {
      this.$parent.toggle(id,$event);
    },

    destroy(id,$event) {
      this.$parent.destroy(id,$event);
    },

    activate($event) {
      this.$parent.activate($event);
    },
  },

  computed: {
    student() {
      if (this.$props.record.id.studentId) {
        return this.$props.record.id.studentId;
      }
      return false;
    }
  }
}
</script>

