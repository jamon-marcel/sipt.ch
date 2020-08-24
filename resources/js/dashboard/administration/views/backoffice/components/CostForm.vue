<template>
  <div class="overlay is-visible">
    <div class="overlay__inner">
      <div>
        <a href @click.prevent="hideOverlay()" class="feather-icon">
          <x-icon size="24"></x-icon>
        </a>
        <div>
          Bitte Betrag für Teilnahme festlegen:<br>
          <ul>
            <li>200.– für aktive/ehem. Teilnehmer</li>
            <li>250.– für übrige</li>
            <li>leer lassen für keine Rechnung</li>
          </ul>
        </div>
        <div class="form-row">
          <label>Betrag</label>
          <input type="text" v-model="amount" v-cleave="{delimiter: '.', blocks: [3]}">
          <label-required />
        </div>
        <div class="sb-sm flex-vc">
          <button class="btn-primary" @click.prevent="save()">Speichern</button>
          <a href="javascript:;" class="btn-close" @click.prevent="hideOverlay()">Abbrechen</a>
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
    subscriber: null,
  },

  data() {
    return {
      amount: null,
    }
  },

  methods: {

    save() {
      if (this.amount == null) {
        this.$notify({
          type: "error",
          text: "Bitte Angaben prüfen!"
        });
        return false;
      }
      this.$parent.saveAmount(this.$props.subscriber, this.amount);
    },

    hideOverlay() {
      this.$parent.hideOverlay();
    },
  }
};
</script>
<style>
ul {
  margin: 10px 0 10px 20px;
  padding: 0;
}
li {
  display: list-item;
}
</style>
