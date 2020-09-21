<template>
  <div class="overlay is-visible">
    <div class="overlay__inner is-wide">
      <div v-if="isFetched">
        <a href @click.prevent="hideMessage()" class="feather-icon">
          <x-icon size="24"></x-icon>
        </a>
        <div>
          <div class="message-header">
            <div><span>Gesendet:</span> <strong>{{message.date}}</strong></div>
            <div><span>Absender:</span> <strong><a :href="'mailto:' + message.senderEmail">{{message.senderName}}</a></strong></div>
            <div><span>Betreff:</span> <strong>{{message.subject}}</strong></div>
          </div>
          <div v-html="message.message">{{message.message}}</div>
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
    messageId: {
      type: String,
      default: null,
    },
  },

  data() {
    return {
      isFetched: false,
      message: null,
    };
  },

  mounted() {
    this.fetch();
  },

  methods: {
    fetch() {
      this.$parent.isLoading = true;
      this.axios.get(`/api/message/${this.$props.messageId}`).then(response => {
        this.message = response.data;
        this.isFetched = true;
        this.$parent.isLoading = false;
      });
    },

    hideMessage() {
      this.$parent.hideMessage();
    }
  }
}
</script>