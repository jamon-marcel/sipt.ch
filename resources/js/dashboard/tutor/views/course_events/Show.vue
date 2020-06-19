<template>
  <div>
   <course-event-show :isTutor="true" :id="$route.params.id"></course-event-show>
  </div>
</template>
<script>
import CourseEventShow from "@/global/components/CourseEventShow";
export default {
  components: {
    CourseEventShow
  },
}
</script>