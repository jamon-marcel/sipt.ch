<template>
  <div class="profile">
    <div class="profile__item">
      <label>Vorname, Name</label>
      {{ tutor.firstname }} {{ tutor.name }}
    </div>
    <div class="profile__item">
      <label>Adresse</label>
      {{ tutor.street }} {{ tutor.street_no }}<br>
      {{ tutor.zip }} {{ tutor.city }}
    </div>
    <div class="profile__item" v-if="tutor.user">
      <label>E-Mail</label>
      {{ tutor.user.email }}
    </div>
    <div class="profile__item">
      <label>Telefon</label>
      {{ tutor.phone }}
    </div>
    <div class="profile__item">
      <label>Mobile</label>
      <span v-if="tutor.mobile">{{ tutor.mobile }}</span>
      <span v-else>–</span>
    </div>
    <div class="profile__item">
      <label>Titel</label>
      {{ tutor.title }}
    </div>
    <div v-if="hasEdit">
      <router-link :to="{name: 'profile-edit', params: { id: tutor.id }}" class="btn-primary is-sm">
        Bearbeiten
      </router-link>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    tutor: {
      type: Object,
    },
    hasEdit: {
      type: Boolean,
      default: false,
    }
  },
}
</script>
