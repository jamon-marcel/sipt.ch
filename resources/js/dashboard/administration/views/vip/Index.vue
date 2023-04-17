<template>
<div>
  <loading-indicator v-if="isLoading"></loading-indicator>
  <div :class="isFetched ? 'is-loaded' : 'is-loading'">
    <header class="content-header">
      <h1>VIP Adressen</h1>
      <router-link :to="{ name: 'vip-address-create' }" class="feather-icon feather-icon--prepend">
        <plus-icon size="16"></plus-icon>
        <span>Hinzufügen</span>
      </router-link>
    </header>
    <div v-if="results">
      <div class="listing" v-if="results.students.length">
        <div 
          class="listing__item"
          v-for="(student, index) in results.students" 
          :key="index">
          <div class="listing__item-body">
            {{student.firstname}} {{student.name}} <separator /> {{student.city}} <separator /> {{student.user.email}} <separator /> {{student.user.id}} <separator /> {{ student.user.is_newsletter_subscriber }}
            <div class="bubble bubble-info" v-if="student.is_active">Student (A)</div>
            <div class="bubble bubble-warning" v-else>Student (I)</div>
          </div>
          <div class="listing__item-action">
            <div>
                <a
                  href="javascript:;"
                  class="feather-icon"
                  @click.prevent="copy(student.user.id)"
                >
                  <copy-icon size="18"></copy-icon>
                </a>
            </div>
          </div>
        </div>
      </div>
      <div class="listing" v-if="results.tutors.length">
        <div 
          class="listing__item"
          v-for="(tutor, index) in results.tutors" 
          :key="index">
          <div class="listing__item-body">
            {{tutor.firstname}} {{tutor.name}} <separator /> {{tutor.city}} <separator /> {{tutor.user.email}} <separator /> {{tutor.user.id}} <separator /> {{ tutor.user.is_newsletter_subscriber }} <div class="bubble bubble-info">Dozent</div>
          </div>
          <div class="listing__item-action">
            <div>
                <a
                  href="javascript:;"
                  class="feather-icon"
                  @click.prevent="copy(tutor.user.id)"
                >
                  <copy-icon size="18"></copy-icon>
                </a>
            </div>
          </div>
        </div>
      </div>
      <div class="listing" v-if="results.vip.length">
        <div 
          class="listing__item"
          v-for="(v, index) in results.vip" 
          :key="index">
          <div class="listing__item-body">
            {{v.firstname}} {{v.name}} <separator /> {{v.city}} <separator /> {{v.email}}<div class="bubble bubble-info">VIP</div>
          </div>
          <div class="listing__item-action">
            <div>
                <a
                  href="javascript:;"
                  class="feather-icon"
                  @click.prevent="copy(v.firstname + ';' + v.name + ';' + v.city + ';' + v.email + ';' + 'vip;')"
                >
                  <copy-icon size="18"></copy-icon>
                </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else>
      <div class="listing" v-if="addresses.length">
        <div
          class="listing__item"
          v-for="a in addresses"
          :key="a.id"
        >
          <div class="listing__item-body">
            <span v-if="a.name">{{a.name }} <separator /></span>
            <span v-if="a.firstname">{{ a.firstname}} <separator /></span>
            <span v-if="a.company">
              {{ a.company }} <separator />
            </span>
            {{ a.city }}
          </div>
          <list-actions 
            :id="a.id" 
            :record="a"
            :hasToggle="false"
            :routes="{edit: 'vip-address-edit'}">
          </list-actions>
        </div>
      </div>
      <div v-else>
        <p class="no-records">Es sind noch keine VIP-Adressen vorhanden...</p>
      </div>
    </div>
    <footer class="module-footer">
      <div class="flex-fe flex-sb">
        <div>
          <a :href="'/export/adressliste/vip?v=' + randomString()" class="btn-primary has-icon" target="_blank">
            <download-icon size="16"></download-icon>
            <span>Export VIP</span>
          </a>
          <a :href="'/export/adressliste/dozenten?v=' + randomString()" class="btn-primary has-icon" target="_blank">
            <download-icon size="16"></download-icon>
            <span>Export Dozenten</span>
          </a>
          <a :href="'/export/adressliste/studenten?v=' + randomString()" class="btn-primary has-icon" target="_blank">
            <download-icon size="16"></download-icon>
            <span>Export Studenten</span>
          </a>
          <a :href="'/export/adressliste/mailing?v=' + randomString()" class="btn-primary has-icon" target="_blank">
            <download-icon size="16"></download-icon>
            <span>Export Mailing</span>
          </a>
        </div>
        <div style="max-width: 360px; margin-left: 20px; width: 100%">
          <input type="text" placeholder="Suche nach Name" v-model="keyword" @blur="search()">
        </div>
      </div>
    </footer>
  </div>
</div>
</template>
<script>

// Icons
import { PlusIcon, DownloadIcon, CopyIcon } from 'vue-feather-icons';

// Mixins
import Helpers from "@/global/mixins/Helpers";
import DateTime from "@/global/mixins/DateTime";
import ErrorHandling from "@/global/mixins/ErrorHandling";

// Components
import ListActions from "@/global/components/ui/ListActions.vue";

export default {

  components: {
    ListActions,
    PlusIcon, 
    DownloadIcon,
    CopyIcon
  },

  mixins: [Helpers, DateTime, ErrorHandling],


  data() {
    return {
      isLoading: false,
      isFetched: false,
      addresses: [],
      keyword: null,
      results: false,
    };
  },

  created() {
    this.fetch();
  },

  methods: {

    fetch() {
      this.axios.get(`/api/vip-addresses`).then(response => {
        this.addresses = response.data.data;
        this.isFetched = true;
      });
    },

    destroy(id, event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/vip-address/${id}`;
        this.isLoading = true;
        this.axios.delete(uri).then(response => {
          this.fetch();
          this.isLoading = false;
        });
      }
    },

    search() {
      this.axios.post('/api/search-address', {keyword: this.keyword}).then(response => {
        this.results = response.data;
        this.keyword = null;
      });
    },

    copy(data) {
      this.$copyText(data).then(function (e) {
        console.log(data);
      });
    },
  }
}
</script>