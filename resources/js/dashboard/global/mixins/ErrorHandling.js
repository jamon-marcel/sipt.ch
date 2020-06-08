export default {

  data() {
    return { 
      errors: null,
    }
  },
  
  mounted() {

    window.intercepted.$on('response:422', data => {
      this.validationError(data);
    });

    window.intercepted.$on('response:404', data => {
      this.notFoundError(data);
    });
  },

  beforeDestroy(){
    window.intercepted.$off('response:422', this.listener);
  },

  methods: {

    validationError(data) {
      let errors = {};
      data.body.forEach(function(key) {
        errors[key.field] = true;
      });
      this.errors = errors;
      this.$notify({ type: "error", text: `Bitte alle mit * markierten Felder prüfen!`});
    },

    serverError(data) {
      this.$notify({ type: "error", text: `${data.status} ${data.code}`});
    },

    notFoundError(data) {
      this.$notify({ type: "error", text: `${data.status} ${data.code}`});
      this.$router.push({ name: 'not-found' });
    },

    forbiddenError(data) {
      this.$notify({ type: "error", text: `${data.status} - Zugriff verweigert!`});
      this.$router.push({ name: 'forbidden' });
    }
  },

};
