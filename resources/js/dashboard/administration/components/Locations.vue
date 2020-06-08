<template>
  <div :class="[cssClass ? cssClass : '', 'form-row']">
    <label>{{label}} <em v-if="required">*</em></label>
    <div class="select-wrapper is-wide">
      <select v-model="value" name="location" @change="change($event.target.value)">
        <option value="null">Bitte wählen...</option>
        <option v-for="l in locations" :key="l.id" :value="l.id">{{ l.name }}, {{ l.city }}</option>
      </select>
    </div>
    <div class="is-required" v-if="required">Pflichtfeld</div>
  </div>  
</template>
<script>
export default {
  props: {
    label: {
      type: String,
      default: ''
    },
    model: {
      type: String,
      default: null,
    },
    name: {
      type: String,
      default: '',
    },
    required: {
      type: Boolean,
      default: false,
    },
    cssClass: {
      type: String,
      default: ''
    },
  },

  data() {
    return {
      locations: [],
      value: null,
    }
  },

  created() {
    this.axios.get(`/api/settings/locations`).then(response => {
      this.locations = response.data.data;
    });
  },

  mounted() {
    this.value = this.$props.model;
  },

  methods: {
    change(value) {
      this.$emit('update:' + this.$props.name, value);
    }
  }
}
</script>
