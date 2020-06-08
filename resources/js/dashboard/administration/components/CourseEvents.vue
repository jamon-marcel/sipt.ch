<template>
  <div>
    <div class="form-row">
      <label>{{label}}</label>
      <div class="select-wrapper is-wide">
        <select name="courses" @change="change($event)">
          <option value="null">Bitte wählen...</option>
          <optgroup :label="course.title" v-for="course in courses" :key="course.id" :value="course.id">
            <option v-for="event in course.events" :key="event.id" :value="event.id" :data-title="course.title" :data-dates="datesToString(event.dates)">
              {{datesToString(event.dates)}}
            </option>
          </optgroup>
        </select>
      </div>
    </div>
    <div class="form-row sb-md">
      <label>{{labelSelected}}</label>
      <div class="listing">
        <div class="listing__item" v-for="c in selection" :key="c.id" data-icons="1">
          <div class="listing__item-body">
            <span class="item-date">{{c.dates}}</span><span class="separator">&bull;</span>{{ c.title }}
          </div>
          <list-actions :id="c.id" :count="1" :hasEdit="false" :hasToggle="false" :record="{id: c}"></list-actions>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
// Components
import ListActions from "@/global/components/ui/ListActions.vue";
import DateTime from "@/global/mixins/DateTime";

export default {
  components: {
    ListActions
  },

  mixins: [DateTime],

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
      title = target.options[target.selectedIndex].dataset.title,
      dates = target.options[target.selectedIndex].dataset.dates;
      const idx = this.selection.findIndex(x => x.id === id);
      if (idx == -1 && id != 'null') {
        this.$parent.addCourse({ id: id, title: title, dates: dates });
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
