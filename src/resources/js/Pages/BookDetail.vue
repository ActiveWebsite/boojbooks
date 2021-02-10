<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ book.title }}
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
        <div :v-if="book.title"> Title: {{book.title}} </br> </div>
        <div :v-if="book.description"> Description: {{book.description}} </br> </div>
        <div :v-if="book.author"> Author:  {{book.author}} </br> </div>
        <div :v-if="book.published"> Published:  {{book.published}} </br> </div>
        <div :v-if="book.length"> Page Length:  {{book.length}} </br> </div>
        <div :v-if="book.rating"> Rating: {{book.rating}} </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";

export default {
  props: ["book"],

  components: {
    AppLayout,
  },
};
</script>
