<template>
<div>
  <notifications classes="notification"/>
</div>
</template>
<script>
export default {
  mounted() {

    // Listen for any intercepted responses under the Client Error category (4xx).
    // window.intercepted.$on('response:422', data => {
    //   //this.validationError(data);
    // });

    // Listen for any intercepted responses under the Server Error category (5xx).
    // window.intercepted.$on('response:5xx', data => {
    //   this.serverError(data);
    // });

    // // Listen for a specific status.
    // window.intercepted.$on('response:404', data => {
    //   this.notFoundError(data);
    // });

    // // Listen for a specific status.
    // window.intercepted.$on('response:403', data => {
    //   this.forbiddenError(data);
    // });

    // // Listen for a specific HTTP code.
    // window.intercepted.$on('response:unprocessable-entity', data => {
    //   this.display(data);
    // });
  },

  methods: {

    validationError() {
      //this.$notify({ type: "error", text: `Bitte alle mit * markierten Felder prüfen!`});
    },

    serverError(data) {
      this.$notify({ type: "error", text: `${data.status} ${data.code}`});
    },

    notFoundError(data) {
      this.$notify({ type: "error", text: `${data.status} ${data.code}`});
    },

    forbiddenError(data) {
      this.$notify({ type: "error", text: `${data.status} - Zugriff verweigert!`});
    }
  }
}
</script>