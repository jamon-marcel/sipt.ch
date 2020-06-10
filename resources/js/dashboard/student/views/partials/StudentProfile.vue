<template>
  <div class="profile">
    <div class="profile__item">
      <label>Vorname, Name</label>
      {{ student.firstname }} {{ student.name }}
    </div>
    <div class="profile__item">
      <label>Adresse</label>
      {{ student.street }} {{ student.street_no }}<br>
      {{ student.zip }} {{ student.city }}
    </div>
    <div class="profile__item" v-if="student.user">
      <label>E-Mail</label>
      {{ student.user.email }}
    </div>
    <div class="profile__item">
      <label>Telefon</label>
      {{ student.phone }}
    </div>
    <div class="profile__item">
      <label>Telefon Geschäft</label>
      <span v-if="student.phone_business">{{ student.phone_business }}</span>
      <span v-else>–</span>
    </div>
    <div class="profile__item">
      <label>Mobile</label>
      <span v-if="student.mobile">{{ student.mobile }}</span>
      <span v-else>–</span>
    </div>
    <div class="profile__item">
      <label>Titel</label>
      {{ student.title }}
    </div>
    <div class="profile__item">
      <label>Berufsabschluss</label>
      {{ student.qualifications }}
    </div>
    <div v-if="hasEdit">
      <router-link :to="{name: 'profile-edit', params: { id: student.id }}" class="btn-primary is-sm">
        Bearbeiten
      </router-link>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    student: {
      type: Object,
    },
    hasEdit: {
      type: Boolean,
      default: false,
    }
  },
}
</script>
