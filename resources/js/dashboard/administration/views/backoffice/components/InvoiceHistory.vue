<template>
  <div class="overlay is-visible" v-if="isFetched">
    <div class="overlay__inner">
      <div>
        <a href @click.prevent="hideHistory()" class="feather-icon">
          <x-icon size="24"></x-icon>
        </a>
        <h2>Rechnung {{invoice.number}} ersetzt:</h2>
        <div class="listing">
          <div class="listing__item">
            <div class="listing__item-body" style="padding-right: 0">
              {{old_invoice.number}}
              <separator />
              {{moneyFormat(old_invoice.amount)}}
              <separator />
              {{old_invoice.date}}
              <separator />
              <span>
                <div class="bubble-invoice bubble-invoice__deleted">Storniert: {{dateFormat(old_invoice.deleted_at, 'DD.MM.YY')}}</div>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

// Icons
import { XIcon } from "vue-feather-icons";

// Mixins
import DateTime from "@/global/mixins/DateTime";
import Helpers from "@/global/mixins/Helpers";

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

  mixins: [Helpers, DateTime],

  data() {
    return {
      old_invoice: null,
      isFetched: false
    }
  },

  created() {
    this.fetch();
  },

  methods: {

    fetch() {
      this.axios.get(`/api/backoffice/invoice/history/${this.$props.invoice.id}`).then(response => {
        this.old_invoice = response.data;
        this.isFetched = true;
      });
    },


    hideHistory() {
      this.$parent.hideHistory();
    },
  }
};
</script>