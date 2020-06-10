<template>
  <div>
    <header class="content-header is-narrow">
      <h1>{{label}}</h1>
      <a href="" @click.prevent="toggle()" class="feather-icon feather-icon--prepend">
        <plus-icon size="18"></plus-icon>
        <span>Hinzufügen</span>
      </a>
    </header>
    <div class="sa-xs" v-if="showCourses">
      <div class="select-wrapper is-wide">
        <select name="courses" @change="change($event)">
          <option value="null">Bitte wählen...</option>
          <optgroup :label="course.title" v-for="course in courses" :key="course.id" :value="course.id">
            <option v-for="event in course.events" :key="event.id" :value="event.id" :data-title="course.title" :data-dates="datesToString(event.dates)">
              {{ datesToString(event.dates) }}
            </option>
          </optgroup>
        </select>
      </div>
    </div>
    <div class="listing" v-if="selection.length">
      <div class="listing__item" v-for="c in selection" :key="c.id" data-icons="1">
        <div class="listing__item-body">
          <span class="item-date">{{c.dates}}</span>
          <span class="separator">&bull;</span>
          {{ c.title }}
        </div>
        <list-actions :id="c.id" :count="1" :hasEdit="false" :hasToggle="false" :record="{id: c}"></list-actions>
      </div>
    </div>
    <div v-else>
      <p class="no-records">Es sind keine weiteren Module gebucht!</p>
    </div>
  </div>
</template>
<script>

// Icons
import { PlusIcon } from 'vue-feather-icons';

// Components
import ListActions from "@/global/components/ui/ListActions.vue";
import Helpers from "@/global/mixins/Helpers";

export default {

  components: {
    ListActions,
    PlusIcon
  },

  mixins: [Helpers],

  props: {

    label: {
      type: String,
      default: ""
    },

    name: {
      type: String,
      default: ""
    },

    records: {
      type: Array,
      default: null
    }
  },

  data() {
    return {
      courses: [],
      selection: [],
      value: null,
      showCourses: false,
    };
  },

  created() {
    this.axios.get(`/api/courses`).then(response => {
      this.courses = response.data.data;
    });
    this.selection = this.$props.records;
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
    },

    toggle() {
      this.showCourses = this.showCourses ? false : true;
    }
  }
};
</script>
