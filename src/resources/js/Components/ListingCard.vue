<template>
    <v-hover>
        <v-card
        xs-6
        slot-scope="{ hover }"
        :class="`elevation-${hover ? 12 : 2}`"
        >
        <!--
            <v-img
            :src="card.src"
            height="200px"
            >
        -->
            <v-container
                fill-height
                fluid
                pa-2
            >
                <v-layout fill-height>
                <v-flex xs12 align-end flexbox>
                    <span class="headline white--text" v-text="list.name"></span>
                </v-flex>
                </v-layout>
            </v-container>
            </v-img>

            <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn icon :href="'listing/' + list.id">
                <v-icon>mdi-book-open-page-variant</v-icon>
            </v-btn>
            <v-btn v-on:click="$emit('delete')"icon>
                <v-icon>mdi-delete</v-icon>
            </v-btn>
            <v-btn v-on:click="$emit('edit')" icon>
                <v-icon>mdi-pencil</v-icon>
            </v-btn>
            </v-card-actions>
        </v-card>
    </v-hover>
</template>

<script>
    export default {
        props: ['list'],
    }
</script>