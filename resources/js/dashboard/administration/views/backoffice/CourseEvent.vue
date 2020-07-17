<template>
  <div>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <div v-if="hasOverlay">
      <notice-form :invoice="noticeInvoice"></notice-form>
    </div>
    <div :class="isFetched ? 'is-loaded' : 'is-loading'">
      <div class="content">
        <template v-if="isFetched">
          <h1>{{title}}</h1>
          <h2 class="is-narrow sb-md">Teilnehmer</h2>
          <div v-if="course_event.students.length">
            <div class="listing">
              <div
                class="listing__item"
                v-for="student in course_event.students"
                :key="student.id"
              >
                <div class="listing__item-body">
                  {{student.firstname}} {{student.name}}
                  <separator />
                  {{student.city}}
                </div>
                <div class="listing__item-action">
                  <div>
                    <a
                      href="javascript:;"
                      @click.prevent="toggleAttendance(student.id, course_event.id)"
                    >
                      <span v-if="student.pivot.has_attendance" class="feather-icon is-active">
                        <check-circle-icon size="20"></check-circle-icon>
                      </span>
                      <span v-else>
                        <circle-icon size="20" class="feather-icon is-inactive"></circle-icon>
                      </span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div v-else>
            <p class="no-records">Es sind keine Teilnehmer für dieses Modul vorhanden...</p>
          </div>
          <h2 class="is-narrow sb-md">Rechnungen</h2>
          <div v-if="course_event.invoices.length">
            <div class="listing">
              <div
                class="listing__item"
                v-for="invoice in course_event.invoices"
                :key="invoice.id"
              >
                <div class="listing__item-body">
                  <a :href="'/storage/invoices/' + invoice.file" target="_blank">{{invoice.number}}</a>
                  <separator />
                  {{moneyFormat(course_event.course.cost)}}
                  <separator />
                  {{invoice.date}}
                  <separator />
                  {{invoice.student.firstname}} {{invoice.student.name}}, {{invoice.student.city}}
                  
                  <span v-if="invoice.state != null && invoice.is_paid == 0">
                    <separator />
                    <div :class="'bubble-invoice bubble-invoice__' + invoice.state">{{invoiceStates[invoice.state]}} - {{invoice.date_notice}}</div>
                  </span>
                  <span v-if="invoice.is_paid">
                    <separator />
                    <div class="bubble-invoice bubble-invoice__paid">Bezahlt</div>
                  </span>
                </div>
                <div class="listing__item-action">
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
          <div v-else>
            <p class="no-records">Es sind keine Rechnungen für dieses Modul vorhanden...</p>
          </div>
        </template>
      </div>
      <footer class="module-footer">
        <div>
          <router-link :to="{ name: 'backoffice-modules' }" class="btn-secondary">
            <span>Zurück</span>
          </router-link>
        </div>
      </footer>
    </div>
  </div>
</template>
<script>
// Icons
import { CheckCircleIcon, CircleIcon, DownloadCloudIcon, DollarSignIcon, BellIcon } from "vue-feather-icons";

// Mixins
import ErrorHandling from "@/global/mixins/ErrorHandling";
import Helpers from "@/global/mixins/Helpers";
import DateTime from "@/global/mixins/DateTime";

// Components
import NoticeForm from '@/administration/views/backoffice/components/NoticeForm.vue';
import ListActions from "@/global/components/ui/ListActions.vue";

export default {
  components: {
    CheckCircleIcon,
    CircleIcon,
    DownloadCloudIcon,
    DollarSignIcon,
    BellIcon,
    ListActions,
    NoticeForm
  },

  mixins: [Helpers, DateTime, ErrorHandling],

  data() {
    return {
      course_event: {},
      isLoading: false,
      isFetched: false,
      hasOverlay: false,
      noticeInvoice: null,

      invoiceStates: {
        0: 'Zahlungserinnerung',
        1: '1. Mahnung',
        2: '2. Mahnung',
        3: '3. Mahnung'
      }
    };
  },

  mounted() {
    this.fetch();
  },

  methods: {
    fetch() {
      let uri = `/api/backoffice/course/event/${this.$route.params.id}`;
      this.axios.get(`${uri}`).then(response => {
        this.course_event = response.data;
        this.isFetched = true;
      });
    },

    toggleAttendance(studentId,courseEventId) {
      let uri = `/api/backoffice/student/attendance/${studentId}/${courseEventId}`;
      this.isLoading = true;
      this.axios.get(uri).then(response => {
        const idx = this.course_event.students.findIndex(x => x.id === studentId);
        this.course_event.students[idx].pivot.has_attendance = response.data;
        this.$notify({ type: "success", text: "Status geändert!" });
        this.isLoading = false;
      });
    },

    toggleBillStatus(invoiceId) {
      let uri = `/api/backoffice/invoice/state/${invoiceId}`;
      this.isLoading = true;
      this.axios.get(uri).then(response => {
        const idx = this.course_event.invoices.findIndex(x => x.id === invoiceId);
        this.course_event.invoices[idx].is_paid = response.data;
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

    showNoticeForm(invoice) {
      this.noticeInvoice = invoice;
      this.hasOverlay = true;
    },

    hideNoticeForm() {
      this.hasOverlay = false;
    },
  },

  computed: {
    title() {
      return `${this.course_event.course.number}.${this.dateFormat(this.course_event.dateStart, 'DDMMYY')} – 
              ${this.course_event.course.title},
              ${this.datesToString(this.course_event.dates)}`;
    }
  }
};
</script>
