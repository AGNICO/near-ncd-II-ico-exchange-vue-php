<template>
  <div id="app" class="bg-gray-100 min-h-screen">
    <NavBar />
    <router-view />
    <Footer class="fixed inset-x-0 bottom-0"/>
  </div>
</template>

<script type="text/javascript">
import NavBar from "@/components/NavBar.vue";
import Footer from "@/components/Footer.vue";

export default {
  components: {
    NavBar,
    Footer,
  },
};
</script>