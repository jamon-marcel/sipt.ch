<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <div v-if="hasHistoryOverlay">
      <invoice-history :invoice="historyInvoice"></invoice-history>
    </div>
    <div v-if="hasNoticeOverlay">
      <notice-form :invoice="noticeInvoice"></notice-form>
    </div>
    <div v-if="hasDateOverlay">
      <date-paid-form :invoice="datePaidInvoice"></date-paid-form>
    </div>
    <div v-if="hasCancelOverlay">
      <cancel-form :invoice="cancelInvoice"></cancel-form>
    </div>
    

    <div class="overlay is-visible" v-if="hasTypeSelectorOverlay">
      <div class="overlay__inner">
        <div>
          <a href @click.prevent="hideTypeSelectorOverlay()" class="feather-icon">
            <x-icon size="24"></x-icon>
          </a>
          <h2>Rechnungstyp wählen</h2>
          <p>Um eine Rechnung für Student:innen mit/ohne Buchung zu erstellen, wählen Sie «Modulrechnung». Wählen Sie «manuelle Rechnung» für alle anderen Fälle (z.B. Charta).</p>
          <div class="flex sb-sm">
            <router-link :to="{ name: 'backoffice-create-invoice' }" class="btn-primary is-sm">Modulrechnung</router-link>
            &nbsp;&nbsp;
            <router-link :to="{ name: 'backoffice-create-manual-invoice' }" class="btn-primary is-sm">manuelle Rechnung</router-link>
          </div>
        </div>
      </div>
    </div>

    <div :class="isFetched ? 'is-loaded' : 'is-loading'">
      <header class="content-header flex-sb flex-vc">
        <h1>Offene Rechnungen</h1>
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
      <div class="content content--wide sb-sm" v-if="invoices.length">
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
              {{invoice.date}}
              <separator/>
              <span v-if="invoice.student">
                {{invoice.student.firstname}} {{invoice.student.name}}, {{invoice.student.city}}
              </span>
              <span v-if="invoice.symposium_subscriber">
                {{invoice.symposium_subscriber.firstname}} {{invoice.symposium_subscriber.name}}, {{invoice.symposium_subscriber.city}}
              </span>
              <span v-if="invoice.tutor">
                {{invoice.tutor.firstname}} {{invoice.tutor.name}}, {{invoice.tutor.city}}
              </span>
              <span v-if="invoice.recipient">
                {{invoice.recipient}}
              </span>
              <span v-if="invoice.state != null && invoice.is_paid == 0">
                <separator/>
                <div
                  :class="'bubble-invoice bubble-invoice__' + invoice.state"
                >{{invoiceStates[invoice.state]}}: {{invoice.date_notice}}</div>
              </span>
              <span v-if="invoice.is_paid">
                <separator/>
                <div class="bubble-invoice bubble-invoice__paid">Bezahlt</div>
              </span>
            </div>
            <div class="listing__item-action">
              <div v-if="invoice.is_replacement">
                <a href @click.prevent="showHistory(invoice)" title="Rechnungshistory anzeigen">
                  <span class="feather-icon">
                    <layers-icon size="20"></layers-icon>
                  </span>
                </a>
              </div>
              <div>
                <a href @click.prevent="showNoticeForm(invoice)" title="Mahnung erstellen">
                  <span class="feather-icon">
                    <bell-icon size="20"></bell-icon>
                  </span>
                </a>
              </div>
              <div>
                <a href="javascript:;" @click.prevent="showDateForm(invoice.id)" title="Rechnungsstatus ändern">
                  <span class="feather-icon">
                    <dollar-sign-icon size="20"></dollar-sign-icon>
                  </span>
                </a>
              </div>
              <div>
                <a href="javascript:;" @click.prevent="showCancelForm(invoice.id)" title="Rechnung stornieren">
                  <span class="feather-icon">
                    <x-circle-icon size="20"></x-circle-icon>
                  </span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-else>
        <p class="no-records">Es sind keine offenen Rechnungen vorhanden...</p>
      </div>
    </div>
    <footer class="module-footer">
      <div class="flex-sb flex-vc">
        <a href="javascript:;" @click.prevent="showTypeSelectorOverlay()" class="btn-primary has-icon">
          <file-plus-icon size="16"></file-plus-icon>
          <span>Rechnung erstellen</span>
        </a>
      </div>
    </footer>
  </div>
</template>
<script>

// Icons
import { DollarSignIcon, BellIcon, LayersIcon, FilePlusIcon, XCircleIcon, XIcon } from "vue-feather-icons";

// Components
import ListActions from "@/global/components/ui/ListActions.vue";
import ViewSelector from "@/administration/components/ViewSelector.vue";
import NoticeForm from "@/administration/views/backoffice/components/NoticeForm.vue";
import DatePaidForm from "@/administration/views/backoffice/components/DatePaidForm.vue";
import CancelForm from "@/administration/views/backoffice/components/CancelForm.vue";
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
    XCircleIcon,
    XIcon,
    ListActions,
    ViewSelector,
    NoticeForm,
    DatePaidForm,
    CancelForm,
    InvoiceHistory
  },

  mixins: [Helpers, DateTime, ErrorHandling],

  data() {
    return {
      invoices: [],
      isLoading: false,
      isFetched: false,

      hasNoticeOverlay: false,
      hasHistoryOverlay: false,
      hasDateOverlay: false,
      hasCancelOverlay: false,
      hasTypeSelectorOverlay: false,

      noticeInvoice: null,
      historyInvoice: null,
      datePaidInvoice: null,
      cancelInvoice: null,

      invoiceStates: {
        0: "Zahlungserinnerung",
        1: "1. Mahnung",
        2: "2. Mahnung",
        3: "3. Mahnung"
      }
    };
  },

  created() {
    this.fetch();
  },

  methods: {
    fetch() {
      this.isLoading = true;
      this.axios.get(`/api/backoffice/invoices`).then(response => {
        this.invoices = response.data.data;
        this.isFetched = true;
        this.isLoading = false;
      });
    },

    update(invoice, date = null) {
      let data = {'date_paid': date};
      let uri = `/api/backoffice/invoice/state/${invoice}`;
      this.isLoading = true;
      this.axios.put(uri, data).then(response => {
        const idx = this.invoices.findIndex(x => x.id === invoice);
        this.invoices.splice(idx,1);
        this.$notify({ type: "success", text: "Status geändert!" });
        this.hideDateForm();
        this.datePaidInvoice = null;
        this.isLoading = false;
      });
    },

    cancel(invoice, date, reason) {
      let data = {
        'is_cancelled': 1,
        'date_cancelled': date,
        'cancel_reason': reason
      };
      let uri = `/api/backoffice/invoice/cancel/${invoice}`;
      this.isLoading = true;
      this.axios.put(uri, data).then(response => {
        const idx = this.invoices.findIndex(x => x.id === invoice);
        this.invoices.splice(idx,1);
        this.$notify({ type: "success", text: "Rechnung storniert!" });
        this.hideCancelForm();
        this.cancelInvoice = null;
        this.isLoading = false;
      });
    },

    storeNotice(noticeType) {
      let uri = `/api/backoffice/invoice/notice/${
        this.noticeInvoice.id
      }/${noticeType}`;
      this.isLoading = true;
      this.axios.get(uri).then(response => {
        this.$notify({ type: "success", text: "Mahnung versendet!" });
        this.noticeInvoice = null;
        this.hideNoticeForm();
        this.isLoading = false;
        this.fetch();
      });
    },

    showHistory(invoice) {
      this.historyInvoice = invoice;
      this.hasHistoryOverlay = true;
    },

    hideHistory() {
      this.historyInvoice = null;
      this.hasHistoryOverlay = false;
    },

    showNoticeForm(invoice) {
      this.noticeInvoice = invoice;
      this.hasNoticeOverlay = true;
    },

    hideNoticeForm() {
      this.noticeInvoice = null;
      this.hasNoticeOverlay = false;
    },

    showDateForm(invoice) {
      this.hasDateOverlay = true;
      this.datePaidInvoice = invoice;
    },

    hideDateForm() {
      this.hasDateOverlay = false;
    },

    showCancelForm(invoice) {
      this.hasCancelOverlay = true;
      this.cancelInvoice = invoice;
    },

    hideCancelForm() {
      this.hasCancelOverlay = false;
    },

    showTypeSelectorOverlay() {
      this.hasTypeSelectorOverlay = true;
    },

    hideTypeSelectorOverlay() {
      this.hasTypeSelectorOverlay = false;
    },
  },
};
</script>