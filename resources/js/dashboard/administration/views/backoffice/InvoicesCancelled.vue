<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <div v-if="hasHistoryOverlay">
      <invoice-history :invoice="historyInvoice"></invoice-history>
    </div>
    <div :class="isFetched ? 'is-loaded' : 'is-loading'">
      <header class="content-header flex-sb flex-vc">
        <h1>Stornierte Rechnungen</h1>
        <view-selector
          :items="[
            {route: '/administration/backoffice/modules', label: 'Module'},
            {route: '/administration/backoffice/invoices', label: 'Rechnungen – offen'},
            {route: '/administration/backoffice/invoices/paid', label: 'Rechnungen – bezahlt'},
            {route: '/administration/backoffice/invoices/cancelled', label: 'Rechnungen – storniert'},
            //{route: '/administration/backoffice/import', label: 'Import'}
          ]"
        ></view-selector>
      </header>
      <div class="content content--wide" v-if="invoices.length">
        <div class="listing">
          <div class="listing__item" v-for="invoice in invoices" :key="invoice.id">
            <div class="listing__item-body">
              <a :href="'/storage/invoices/' + invoice.file" target="_blank">{{invoice.number}}</a>
              <span v-if="invoice.event">
                <separator/>
                {{invoice.event.courseNumber}}
              </span>
              <span v-else-if="invoice.symposium_subscriber">
                <separator/>
                100.101020
              </span>
              <separator/>
              {{moneyFormat(invoice.amount)}}
              <separator/>
              {{invoice.date_cancelled}}
              <separator/>
              <span v-if="invoice.student">
                {{invoice.student.firstname}} {{invoice.student.name}}, {{invoice.student.city}}
              </span>
              <span v-if="invoice.symposium_subscriber">
                {{invoice.symposium_subscriber.firstname}} {{invoice.symposium_subscriber.name}}, {{invoice.symposium_subscriber.city}}
              </span>
              <span class="bubble-info">
                {{invoice.cancel_reason | truncate('25', '...')}}
              </span>
            </div>
            <div class="listing__item-action">
              <div v-if="invoice.is_replacement">
                <a href @click.prevent="showHistory(invoice)">
                  <span class="feather-icon">
                    <layers-icon size="20"></layers-icon>
                  </span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-else>
        <p class="no-records">Es sind keine stornierten Rechnungen vorhanden...</p>
      </div>
    </div>
  </div>
</template>
<script>

// Icons
import { DollarSignIcon, BellIcon, LayersIcon, FilePlusIcon } from "vue-feather-icons";

// Components
import ListActions from "@/global/components/ui/ListActions.vue";
import ViewSelector from "@/administration/components/ViewSelector.vue";
import InvoiceHistory from "@/administration/views/backoffice/components/InvoiceHistory.vue";

// Mixins
import Helpers from "@/global/mixins/Helpers";
import DateTime from "@/global/mixins/DateTime";
import ErrorHandling from "@/global/mixins/ErrorHandling";

export default {
  components: {
    DollarSignIcon,
    BellIcon,
    LayersIcon,
    FilePlusIcon,
    ListActions,
    ViewSelector,
    InvoiceHistory
  },

  mixins: [Helpers, DateTime, ErrorHandling],

  data() {
    return {
      invoices: [],
      isLoading: false,
      isFetched: false,
      hasHistoryOverlay: false,
      historyInvoice: null,
    };
  },

  created() {
    this.fetch();
  },

  methods: {
    fetch() {
      this.isLoading = true;
      this.axios.get(`/api/backoffice/invoices/cancelled`).then(response => {
        this.invoices = response.data.data;
        this.isFetched = true;
        this.isLoading = false;
      });
    },

    update(invoice, date = null) {

      if (confirm('Sind Sie sicher, dass Sie den Rechnungsstatus auf «nicht bezahlt» ändern möchten?')) {
        let data = {'date_paid': date};
        let uri = `/api/backoffice/invoice/state/${invoice}`;
        this.isLoading = true;
        this.axios.put(uri, data).then(response => {
          const idx = this.invoices.findIndex(x => x.id === invoice);
          this.invoices.splice(idx,1);
          this.$notify({ type: "success", text: "Status geändert!" });
          this.isLoading = false;
        });
      }
    },

    showHistory(invoice) {
      this.historyInvoice = invoice;
      this.hasHistoryOverlay = true;
    },

    hideHistory() {
      this.historyInvoice = null;
      this.hasHistoryOverlay = false;
    },
  },
};
</script>