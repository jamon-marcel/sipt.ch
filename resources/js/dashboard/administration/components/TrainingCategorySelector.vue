<template>
  <div :class="[cssClass ? cssClass : '', 'form-row']">
    <label>{{label}} <em v-if="required">*</em></label>
    <div class="select-wrapper is-wide">
      <select v-model="value" name="categories" @change="change($event.target.value)">
        <option value="null">Bitte wählen...</option>
        <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
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
      categories: [],
      value: null,
    }
  },

  created() {
    this.axios.get(`/api/settings/training/categories`).then(response => {
      this.categories = response.data.data;
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
