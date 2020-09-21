<template>
  <div class="overlay is-visible">
    <div class="overlay__inner is-wide">
      <div>
        <a href @click.prevent="hideMessageForm()" class="feather-icon">
          <x-icon size="24"></x-icon>
        </a>
        <div class="sa-xs">
          <h2>Neue Nachricht</h2>
          <div>Senden Sie eine Nachricht per E-Mail an alle angemeldeten TeilnehmerInnen dieses Kurses.</div>
        </div>
        <div class="form-row">
          <label>Betreff</label>
          <input type="text" name="subject" v-model="subject">
          <label-required />
        </div>
        <div class="form-row">
          <label>Inhalt</label>
          <textarea name="message" v-model="message"></textarea>
          <label-required />
        </div>
        <div class="sb-sm flex-vc">
          <button class="btn-primary" @click.prevent="store()">Senden</button>
          <a href="javascript:;" class="btn-close" @click.prevent="hideMessageForm()">Abbrechen</a>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

// Components
import LabelRequired from "@/global/components/ui/LabelRequired.vue";

// Icons
import { XIcon } from "vue-feather-icons";

export default {
  components: {
    XIcon,
    LabelRequired
  },

  data() {
    return {
      message: null,
      subject: null,
    }
  },

  methods: {

    store() {
      if (this.message == null || this.subject == null) {
        this.$notify({
          type: "error",
          text: "Bitte Angaben prüfen!"
        });
        return false;
      }
      let data = {
        'subject': this.subject,
        'message': this.message
      };

      if (confirm('Bitte senden bestätigen!')) {
        this.$parent.storeMessage(data);
      }
    },

    hideMessageForm() {
      this.$parent.hideMessageForm();
    },
  }
};
</script>