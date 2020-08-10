<template>
  <div class="overlay is-visible">
    <div class="overlay__inner">
      <div>
        <a href @click.prevent="hideCancelForm()" class="feather-icon">
          <x-icon size="24"></x-icon>
        </a>
        <div class="form-row">
          <label>Stornierungsdatum</label>
          <input type="text" v-model="date_cancel" v-cleave="{delimiter: '.', blocks: [2, 2, 4]}">
          <label-required />
        </div>
        <div class="form-row">
          <label>Grund</label>
          <textarea name="reason" v-model="cancel_reason"></textarea>
          <label-required />
        </div>
        <div class="sb-sm flex-vc">
          <button class="btn-primary" @click.prevent="cancel()">Speichern</button>
          <a href="javascript:;" class="btn-close" @click.prevent="hideCancelForm()">Abbrechen</a>
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

  props: {
    invoice: null,
  },

  data() {
    return {
      date_cancel: null,
      cancel_reason: null,
    }
  },

  methods: {

    cancel() {
      if (this.date_cancel == null || this.cancel_reason == null) {
        this.$notify({
          type: "error",
          text: "Bitte Angaben prüfen!"
        });
        return false;
      }
      this.$parent.cancel(this.$props.invoice, this.date_cancel, this.cancel_reason);
    },

    hideCancelForm() {
      this.$parent.hideCancelForm();
    },
  }
};
</script>