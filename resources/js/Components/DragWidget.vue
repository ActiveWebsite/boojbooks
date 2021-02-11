<template>
  <v-layout>
    <v-icon small class="page__grab-icon" v-show="active"> mdi-arrow-all </v-icon>
    {{ order }}
  </v-layout>
</template>

<script>
export default {
  props: ["order", "active", "book", "listing"],

  watch: {
    $props: {
      deep: true,
      handler: function (newValue, oldValue) {
        console.log(newValue + " " + oldValue);
        if (this.active) {
          var data = {
            id: this.book.id,
            list_order: this.order,
            title: this.book.title,
            description: this.book.description,
          };
          data._method = "PUT";
          axios.post("/book/" + this.book.id, data).then((response) => {
            console.log(response);
          });
        }
      },
    },
  },
};
</script>
