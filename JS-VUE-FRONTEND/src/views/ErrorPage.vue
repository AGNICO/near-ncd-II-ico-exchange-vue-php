<template>
  <div>
    <error :error="error"/>
  </div>
</template>

<script>
import Error from '../components/Error.vue'

export default {
  name: 'Buy',
  props: [
    'error'
  ],
  components: {
    Error
  }
}
</script>
