<template>
  <div>
    <success :success="success"/>
  </div>
</template>

<script>
import Success from '../components/Success.vue'

export default {
  name: 'SuccessPage',
  props: [
    'success'
  ],
  components: {
    Success
  }
}
</script>
