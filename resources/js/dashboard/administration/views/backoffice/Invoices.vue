<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  <div v-if="hasHistoryOverlay">
    <invoice-history :invoice="historyInvoice"></invoice-history>
  </div>
  <div v-if="hasNoticeOverlay">
    <notice-form :invoice="noticeInvoice"></notice-form>
  </div>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <header class="content-header flex-sb flex-vc">
      <h1>Offene Rechnungen</h1>
      <view-selector></view-selector>
    </header>
    <div class="content content--wide sb-sm" v-if="invoicesOpen.length">
      <div class="listing">
        <div
          class="listing__item"
          v-for="invoice in invoicesOpen"
          :key="invoice.id"
        >
          <div class="listing__item-body">
            <a :href="'/storage/invoices/' + invoice.file" target="_blank">{{invoice.number}}</a>
            <separator />
            {{moneyFormat(invoice.amount)}}
            <separator />
            {{invoice.date}}
            <separator />
            <span v-if="invoice.student">
              {{invoice.student.firstname}} {{invoice.student.name}}, {{invoice.student.city}}
              <separator />
              {{invoice.event.course.title}}
            </span>
            <span v-if="invoice.symposium_subscriber">
              {{invoice.symposium_subscriber.firstname}} {{invoice.symposium_subscriber.name}}, {{invoice.symposium_subscriber.city}}
              <separator />
              Fachtagung
            </span>
            <span v-if="invoice.state != null && invoice.is_paid == 0">
              <separator />
              <div :class="'bubble-invoice bubble-invoice__' + invoice.state">{{invoiceStates[invoice.state]}}: {{invoice.date_notice}}</div>
            </span>
            <span v-if="invoice.is_paid">
              <separator />
              <div class="bubble-invoice bubble-invoice__paid">Bezahlt</div>
            </span>
          </div>
          <div class="listing__item-action">

            <div v-if="invoice.is_replacement">
              <a href="" @click.prevent="showHistory(invoice)">
                <span class="feather-icon">
                  <layers-icon size="20"></layers-icon>
                </span>
              </a>
            </div>

            <div v-if="invoice.is_paid == 0">
              <a href="" @click.prevent="showNoticeForm(invoice)">
                <span class="feather-icon">
                  <bell-icon size="20"></bell-icon>
                </span>
              </a>
            </div>
            <div>
              <a
                href="javascript:;"
                @click.prevent="toggleBillStatus(invoice.id)"
              >
                <span v-if="invoice.is_paid" class="feather-icon is-active">
                  <dollar-sign-icon size="20"></dollar-sign-icon>
                </span>
                <span v-else>
                  <dollar-sign-icon size="20" class="feather-icon is-inactive"></dollar-sign-icon>
                </span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else><p class="no-records">Es sind keine offenen Rechnungen vorhanden...</p></div>
    <header class="content-header sb-md">
      <h1>Bezahlte Rechnungen</h1>
    </header>
    <div class="content content--wide" v-if="invoicesPaid.length">
      <div class="listing">
        <div
          class="listing__item"
          v-for="invoice in invoicesPaid"
          :key="invoice.id"
        >
          <div class="listing__item-body">
            <a :href="'/storage/invoices/' + invoice.file" target="_blank">{{invoice.number}}</a>
            <separator />
            {{moneyFormat(invoice.amount)}}
            <separator />
            {{invoice.date}}
            <separator />
            <span v-if="invoice.student">
              {{invoice.student.firstname}} {{invoice.student.name}}, {{invoice.student.city}}
              <separator />
              {{invoice.event.course.title}}
            </span>
            <span v-if="invoice.symposium_subscriber">
              {{invoice.symposium_subscriber.firstname}} {{invoice.symposium_subscriber.name}}, {{invoice.symposium_subscriber.city}}
              <separator />
              Fachtagung
            </span>
          </div>
          <div class="listing__item-action">
            <div v-if="invoice.is_replacement">
              <a href="" @click.prevent="showHistory(invoice)">
                <span class="feather-icon">
                  <layers-icon size="20"></layers-icon>
                </span>
              </a>
            </div>
            <div>
              <a
                href="javascript:;"
                @click.prevent="toggleBillStatus(invoice.id)"
              >
                <span v-if="invoice.is_paid" class="feather-icon is-active">
                  <dollar-sign-icon size="20"></dollar-sign-icon>
                </span>
                <span v-else>
                  <dollar-sign-icon size="20" class="feather-icon is-inactive"></dollar-sign-icon>
                </span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else><p class="no-records">Es sind keine bezahlten Rechnungen vorhanden...</p></div>
  </div>
</div>
</template>
<script>

// Icons
import { DollarSignIcon, BellIcon, LayersIcon } from 'vue-feather-icons';

// Components
import ListActions from "@/global/components/ui/ListActions.vue";
import ViewSelector from '@/administration/views/backoffice/components/ViewSelector.vue';
import NoticeForm from '@/administration/views/backoffice/components/NoticeForm.vue';
import InvoiceHistory from '@/administration/views/backoffice/components/InvoiceHistory.vue';


// Mixins
import Helpers from "@/global/mixins/Helpers";
import DateTime from "@/global/mixins/DateTime";
import ErrorHandling from "@/global/mixins/ErrorHandling";

export default {

  components: {
    DollarSignIcon,
    BellIcon,
    LayersIcon,
    ListActions,
    ViewSelector,
    NoticeForm,
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

      noticeInvoice: null,
      historyInvoice: null,

      invoiceStates: {
        0: 'Zahlungserinnerung',
        1: '1. Mahnung',
        2: '2. Mahnung',
        3: '3. Mahnung'
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

    toggleBillStatus(invoiceId) {
      let uri = `/api/backoffice/invoice/state/${invoiceId}`;
      this.isLoading = true;
      this.axios.get(uri).then(response => {
        const idx = this.invoices.findIndex(x => x.id === invoiceId);
        this.invoices[idx].is_paid = response.data;
        this.$notify({ type: "success", text: "Status geändert!" });
        this.isLoading = false;
      });
    },

    storeNotice(noticeType) {
      let uri = `/api/backoffice/invoice/notice/${this.noticeInvoice.id}/${noticeType}`;
      this.isLoading = true;
      this.axios.get(uri).then(response => {
        this.$notify({ type: "success", text: "Mahnung versendet!"});
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

    filterByState(data, state) {
      let invoices = data.filter(function(invoice) {
        return invoice.is_paid == state;
      });
      return invoices;
    }

  },

  computed: {
    coursesConcluded() {
      let courses = this.courses.filter(function(course) {
        return course.events_completed.length;
      });
      return courses;
    },

    invoicesPaid() {
      let invoices = this.invoices.filter(function(invoice) {
        return invoice.is_paid == 1;
      });
      return invoices;
    },

    invoicesOpen() {
      let invoices = this.invoices.filter(function(invoice) {
        return invoice.is_paid == 0;
      });
      return invoices;
    },
  }
}
</script>