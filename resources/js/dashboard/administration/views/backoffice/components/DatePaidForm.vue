<template>
  <div class="overlay is-visible">
    <div class="overlay__inner">
      <div>
        <a href @click.prevent="hideDateForm()" class="feather-icon">
          <x-icon size="24"></x-icon>
        </a>
        <div class="form-row">
          <label>Zahlungsdatum</label>
          <input type="text" v-model="date" v-cleave="{delimiter: '.', blocks: [2, 2, 4]}">
        </div>
        <div class="sb-sm">
          <button class="btn-primary" @click.prevent="update()">Speichern</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

// Icons
import { XIcon } from "vue-feather-icons";

export default {
  components: {
    XIcon
  },

  props: {
    invoice: null,
  },

  data() {
    return {
      date: null,
    }
  },

  methods: {

    update() {
      if (this.date == null) {
        this.$notify({
          type: "error",
          text: "Datum fehlt!"
        });
        return false;
      }
      this.$parent.update(this.$props.invoice, this.date);
    },

    hideDateForm() {
      this.$parent.hideDateForm();
    },
  }
};
</script>