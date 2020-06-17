<template>
  <div>
   <course-event-show :isAdmin="true" :id="$route.params.id"></course-event-show>
  </div>
</template>
<script>
// Components
import CourseEventShow from "@/global/components/CourseEventShow";

export default {
  components: {
    CourseEventShow
  },
}
</script>
