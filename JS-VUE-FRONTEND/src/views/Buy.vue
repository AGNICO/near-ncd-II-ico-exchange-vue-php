<template>
  <div>
    <buy-tokens :price='price'/>
  </div>
</template>

<script>
import BuyTokens from '../components/BuyTokens.vue'

export default {
  name: 'Buy',
  props: ['price'],
  components: {
    BuyTokens,
  },
}
</script>
