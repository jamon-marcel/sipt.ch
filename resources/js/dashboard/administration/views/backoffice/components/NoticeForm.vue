<template>
  <div class="overlay is-visible">
    <div class="overlay__inner">
      <div>
        <a href @click.prevent="hideNoticeForm()" class="feather-icon">
          <x-icon size="24"></x-icon>
        </a>
        <h2>Mahnung auslösen für:</h2>
        <div class="listing">
          <div class="listing__item">
            <div class="listing__item-body">
              <span>{{invoice.number}}</span>
              <separator />
              <span>{{invoice.date}}</span>
              <separator />
              <span v-if="invoice.student">{{invoice.student.firstname}} {{invoice.student.name}}</span>
              <span v-if="invoice.symposium_subscriber">{{invoice.symposium_subscriber.firstname}} {{invoice.symposium_subscriber.name}}</span>
            </div>
          </div>
        </div>
        <div class="form-row">
          <h2>Typ</h2>
          <div class="select-wrapper is-light is-wide">
            <select v-model="notice_type" name="notice_type">
              <option value="null">Bitte wählen...</option>
              <option v-for="(t, index) in notice_types" :key="index" :value="t.value">{{ t.label }}</option>
            </select>
          </div>
        </div>
        <div class="sb-sm">
          <button class="btn-primary" @click.prevent="store()">Senden</button>
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
    invoice: {
      type: Object,
      default: null
    },
  },

  data() {
    return {
      notice_type: null,
      notice_types: [
        {
          value: 0,
          label: 'Zahlungserinnerung'
        },
        {
          value: 1,
          label: '1. Mahnung'
        },
        {
          value: 2,
          label: '2. Mahnung'
        },
        {
          value: 3,
          label: '3. Mahnung'
        },
      ]
    }
  },

  methods: {

    store() {
      if (this.notice_type == null) {
        this.$notify({
          type: "error",
          text: "Bitte Typ auswählen!"
        });
        return false;
      }
      this.$parent.storeNotice(this.notice_type);
    },

    hideNoticeForm() {
      this.$parent.hideNoticeForm();
    },
  }
};
</script>