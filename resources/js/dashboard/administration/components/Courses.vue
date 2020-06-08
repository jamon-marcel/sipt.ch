<template>
  <div>
    <div class="form-row">
      <label>{{label}}</label>
      <div class="select-wrapper is-wide">
        <select name="courses" @change="change($event)">
          <option value="null">Bitte wählen...</option>
          <option v-for="c in courses" :key="c.id" :value="c.id">{{ c.title }}</option>
        </select>
      </div>
    </div>
    <div class="form-row sb-md">
      <label>{{labelSelected}}</label>
      <div class="listing">
        <div class="listing__item" v-for="c in selection" :key="c.id" data-icons="1">
          <div class="listing__item-body">{{ c.title }}</div>
          <list-actions :id="c.id" :count="1" :hasEdit="false" :hasToggle="false" :record="{id: c}"></list-actions>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
// Components
import ListActions from "@/global/components/ui/ListActions.vue";

export default {
  components: {
    ListActions
  },

  props: {
    label: {
      type: String,
      default: ""
    },
    labelSelected: {
      type: String,
      default: ""
    },
    name: {
      type: String,
      default: ""
    },
    data: {
      type: Array,
      default: null
    }
  },

  data() {
    return {
      courses: [],
      selection: [],
      value: null
    };
  },

  created() {
    this.axios.get(`/api/courses`).then(response => {
      this.courses = response.data.data;
    });
    this.selection = this.$props.data;
  },

  methods: {
    change(event) {
      let target = event.target,
        id = target.value,
        title = target.options[target.selectedIndex].innerHTML;
      const idx = this.selection.findIndex(x => x.id === id);
      if (idx == -1 && id != 'null') {
        this.$parent.addCourse({ id: id, title: title });
      }
    },

    destroy(id) {
      const idx = this.selection.findIndex(x => x.id === id);
      if (idx > -1) {
        this.$parent.removeCourse(id);
      }
    }
  }
};
</script>
