<template>
  <div>
    <label>{{label}} <em v-if="required">*</em></label>
    <div class="select-wrapper is-wide">
      <select v-model="value" name="tutor" @change="change($event.target.value)">
        <option value="null">Bitte wählen...</option>
        <option v-for="t in tutors" :key="t.id" :value="t.id">{{ t.firstname }} {{ t.name }}, {{ t.city }}</option>
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
    }
  },

  data() {
    return {
      tutors: [],
      value: null,
    }
  },

  created() {
    this.axios.get(`/api/tutors/active`).then(response => {
      this.tutors = response.data.data;
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
