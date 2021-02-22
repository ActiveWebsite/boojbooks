<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        
        <v-card
        xs-6
        :href="'listing/'"
        >
            <v-container
                fill-height
                fluid
                pa-2
            >
                <v-layout fill-height>
                <v-flex xs12 align-end flexbox>
                    <span class="headline white--text">Create a book list</span>
                </v-flex>
                </v-layout>
            </v-container>
            </v-img>

            <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn icon :href="'listing/'">
                <v-icon>mdi-book-open-page-variant</v-icon>
            </v-btn>
            </v-card-actions>
        </v-card>
  
        
        
        
        
        
        
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";

export default {
  components: {
    AppLayout,
    Welcome,
  },
};
</script>
