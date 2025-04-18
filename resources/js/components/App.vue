<template>
  <div class="app-container">
    <!-- Mount the project showcase component here -->
    <ProjectShowcaseComponent />
    
    <!-- Mount the pricing component here -->
    <PricingComponent />
  </div>
</template>

<script>
import PricingComponent from './PricingComponent.vue';
import ProjectShowcaseComponent from './ProjectShowcaseComponent.vue';

export default {
  name: 'App',
  components: {
    PricingComponent,
    ProjectShowcaseComponent
  }
}
</script>

<style scoped>
.app-container {
  padding: 2rem;
  text-align: center;
}
</style> 