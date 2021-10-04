<template>
  <div>
    <div class="form-row">
      <label>{{label}}</label>
      <div class="select-wrapper is-wide">
        <select name="specialisations" @change="change($event)">
          <option value="null">Bitte wählen...</option>
          <option v-for="s in specialisations" :key="s.id" :value="s.id">{{ s.description }}</option>
        </select>
      </div>
    </div>
    <div class="form-row sb-md">
      <label>{{labelSelected}}</label>
      <div class="listing">
        <div class="listing__item" v-for="s in selection" :key="s.id">
          <div class="listing__item-body">{{ s.description }}</div>
          <list-actions :id="s.id" :hasEdit="false" :hasToggle="false" :record="{id: s}"></list-actions>
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
      specialisations: [],
      selection: [],
      value: null
    };
  },

  created() {
    this.axios.get(`/api/settings/specialisations`).then(response => {
      this.specialisations = response.data.data;
    });
    this.selection = this.$props.data;
  },

  methods: {
    change(event) {
      let target = event.target, id = target.value, description = target.options[target.selectedIndex].innerHTML;
      const idx = this.selection.findIndex(x => x.id === id);
      if (idx == -1 && id != "null") {
        this.$parent.addSpecialisation({ id: id, description: description });
      }
    },

    destroy(id) {
      const idx = this.selection.findIndex(x => x.id === id);
      if (idx > -1) {
        this.$parent.removeSpecialisation(id);
      }
    }
  }
};
</script>
