<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Book Details
            </h2>
        </template>

        <div>
            <div class="mx-auto py-10 sm:px-6 lg:px-8">
                    <div class="relative w-3/4" v-bind:style="{'float':'left'}">
                        <div><strong>{{book.title}}</strong></div>
                        <div class="mt-5">{{book.description}}</div>
                    </div>
                    <div  class="relative mb-10">
                        <div class="mt-2">
                            <img :src="book.cover_image" class="object-cover">
                        </div>
                    </div>
                    <div class="w-3/4 mt-10">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            Publication
                        </h2>
                        <div>Publisher: {{book.publisher}}</div>
                        <div>Publication Date: {{book.publication_date}}</div>
                    </div>

                    <div>
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-10">
                            Rating
                        </h2>
                        <div>Average Rating: {{book.rating}}</div>
                    </div>

                    <div>
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-10">
                            Authors
                        </h2>
                        <div>
                            <template v-if="book.authors">
                                <span
                                        v-for="(author, authorIndex) of book.authors"
                                        :key="authorIndex"
                                >{{ author.name }}</span>
                            </template>
                        </div>
                    </div>

                    <div>
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-10">
                            Genres
                        </h2>
                        <div>
                            <template v-if="book.genres">
                                <span
                                        v-for="(genre, genreIndex) of book.genres"
                                        :key="genreIndex"
                                >{{ genre.name }}</span>
                            </template>
                        </div>
                    </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    export default {
        components: {
        },
        props: {
            props: ['book'],
        },
        data() {
            return {
                book: this.$inertia.page.props.book,
            }
        },
        methods: {
        },
        mounted() {
        },
        created() {}
    }
</script>
