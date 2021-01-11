<template>
  <v-app id="booj-books">
    <v-main>
      <router-view class="ma-3 pa-3"></router-view>
    </v-main>
  </v-app>
</template>
<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';

@Component
export default class App extends Vue {
  protected beforeCreate() {}
  protected created() {}
  protected beforeMount() {}
  protected mounted() {}
  protected beforeUpdate() {}
  protected updated() {}
  protected beforeDestroy() {}
  protected destroyed() {}
}
</script>

<style lang="scss">
.v-application--wrap {
  min-height: 0vh !important;
}
</style>
