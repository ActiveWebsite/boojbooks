<template>
    <div>
        <div class="w-full text-center">
            <div class="space-y-2 m-3 w-full">
                <input id="bookSearch" type="text" class="mt-1 block" v-model="bookSearch" v-bind:style="{width: '98%'}"
                       placeholder="Search to add a book by Title, Author, Publication"
                       @click="searchBooks"
                       @keydown="searchBooks"
                />
            </div>
            <div v-if="apiResults" class ="border-2">
                <div class="row block w-full"
                        v-for="(book, index) of apiResults.items"
                        :key="index"
                >
                    <div class="col-span-6">
                        <div class="container p-2">
                            <table class="w-full w-">
                                <tr class="m-2">
                                    <td width="60%" v-bind:style="{'text-align':'left'}"><strong>{{ book.volumeInfo.title }}</strong> <br/>
                                        <strong>Publisher:</strong> {{ book.volumeInfo.publisher }} <br/>
                                        <strong>Pages:</strong> {{ book.volumeInfo.pageCount }}
                                    </td>
                                    <td width="30%"><img
                                            v-if="book.volumeInfo.imageLinks && book.volumeInfo.imageLinks.smallThumbnail"
                                            class="max-h-24"
                                            :src="book.volumeInfo.imageLinks.smallThumbnail"
                                        />
                                    </td>
                                    <td width="10%">
                                        <button v-on:click="addBook(book)">ADD</button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="text-center" v-if="apiResults.totalItems > 3">
                    <button v-if="apiResults.totalItems > 3"
                                v-on:click="changeStartIndex(-3)"
                                :disabled="startIndex === 0 ? true : false"><< Prev
                    </button>

                    <button
                            v-on:click="changeStartIndex(3)"
                            :disabled="apiResults.totalItems - 5 <= startIndex ? true : false">Next >>
                    </button>
                </div>
            </div>
        </div>
        <div class="ml-4" v-bind:style="{'float':'left'}">To rearrange the books, please drag n drop rows below.</div>
        <div v-bind:style="{'float':'right'}">Sort By:
            <select v-model="orderBy" v-on:change="sortBooks($event)" v-bind:style="{'line-height':'0.9'}">
                <option  value="" :selected="orderBy === ''">Default</option>
                <option  value="books.id desc" :selected="orderBy === 'books.id desc'">Latest First</option>
                <option  value="books.id asc" :selected="orderBy === 'books.id asc'">Oldest First</option>
            </select>
        </div>
        <div class="mb-4 border border-b-2">
            <div class="inline-flex w-full">
                <div class="w-full bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0 items-center font-semibold">
                    <span class="inline-flex flex-row  w-48 m-3 text-center"> </span>
                    <span class="inline-flex flex-row  w-48 m-3 text-center">Title</span>
                    <span class="inline-flex flex-row  w-48 m-3 text-center">Author</span>
                    <span class="inline-flex flex-row  w-48 m-3 text-center">Genre</span>
                    <span class="inline-flex flex-row  w-48 m-3 text-center">Rating</span>
                    <span class="inline-flex flex-row  w-48 m-3 text-center"></span>
                </div>
            </div>
            <template v-if="books">
                <draggable v-model="books" @update="rearrangeBooks">
                    <div class="inline-block w-full bg-gray-50 dark:bg-gray-900 align"
                         v-for="(book, index) of books"
                         :key=book.id
                    >
                        <span class="inline-flex flex-row  w-48 m-3" v-bind:style="{'display':'table-cell', 'vertical-align':'top', 'text-align':'-webkit-center'}">
                            <img :src="book.cover_image" alt="" />
                        </span>
                        <span class="inline-flex flex-row  w-48 m-3" v-bind:style="{'display':'table-cell', 'vertical-align':'top'}">{{ book.title }}</span>
                        <span class=" inline-flex flex-row  w-48 m-3" v-bind:style="{'display':'table-cell', 'vertical-align':'top'}">
                            <template v-if="book.authors">
                                <span
                                      v-for="(author, authorIndex) of book.authors"
                                      :key="authorIndex"
                                >{{ author.name }}</span>
                            </template>
                        </span>
                        <span class="inline-flex flex-row  w-48 m-3" v-bind:style="{'display':'table-cell', 'vertical-align':'top'}">
                            <template v-if="book.genres">
                                <span
                                      v-for="(genre, genreIndex) of book.genres"
                                      :key="genreIndex"
                                >{{ genre.name }}</span>
                            </template>
                        </span>

                        <span class="inline-flex flex-row  w-48 m-3" v-bind:style="{'display':'table-cell', 'vertical-align':'top', 'text-align':'-webkit-center'}">{{ book.rating }}</span>
                        <span class="inline-flex flex-row  w-48 m-3" v-bind:style="{'display':'table-cell', 'vertical-align':'top', 'text-align':'-webkit-center'}">
                            <button v-on:click="viewBookDetails(book)">VIEW DETAILS</button>
                            <br/>
                            <button v-on:click="removeBook(book)">REMOVE</button>
                        </span>
                    </div>
                </draggable>
            </template>
            <template v-else>
                <div class="m-3">Please search and add books to your list.</div>
            </template>
        </div>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'
    import axios from 'axios'
    import Button from "../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Button"

    export default {
        components: {
            Button,
            draggable,
        },
        props: {
            props: ['books', 'apiResults', 'bookSearch', 'searchQuery', 'startIndex', 'orderBy'],
        },
        data() {
            return {
                books: this.$inertia.page.props.books,
                apiResults: null,
                searchQuery: "",
                startIndex: 0,
                bookSearch: "",
                orderBy: "",
            }
        },
        methods: {
            async searchBooks() {
                if (this.bookSearch.length == 0) {
                    return
                }
                this.searchQuery = this.bookSearch
                this.startIndex = 0
                await this.performApiSearch()
            },
            async performApiSearch() {
                const apiURL = 'https://www.googleapis.com/books/v1/volumes'
                const http = axios.create()
                try {
                    const maxResults = 3
                    const url = apiURL+`?q=${encodeURIComponent(this.searchQuery,)}&startIndex=${this.startIndex}&maxResults=${maxResults}`
                    // Because of CORS issues with googleapis, have to use http.get here
                    const result = await http.get(url)
                    this.apiResults = result.data
                    if (!this.apiResults) {
                        return
                    }
                } catch (ex) {
                    // Log Error
                }
            },
            changeStartIndex(index) {
                this.startIndex += index
                this.performApiSearch()
            },
            async viewBookDetails(book) {
                let book_id = book.id
                let data = {}
                let page = this.httpRequest('get', '/books/' + book_id, data)
            },
            async removeBook(book) {
                let book_id = book.id
                let data = {id: book.id,}
                let page = this.httpRequest('delete', '/books', data)
            },
            async addBook(book) {
                let data = {
                    title: book.volumeInfo.title,
                    cover_image: book.volumeInfo.imageLinks?.thumbnail,
                    cover_image_small: book.volumeInfo.imageLinks?.smallThumbnail,
                    publication_date: book.volumeInfo.publishedDate,
                    description: book.volumeInfo.description,
                    authors: book.volumeInfo.authors,
                    publisher: book.volumeInfo.publisher,
                    genres: book.volumeInfo.categories,
                    unique_id: book.id,
                    rating: book.volumeInfo.averageRating,
                }
                let page = this.httpRequest('post', '/books', data)
            },
            async sortBooks(event) {
                this.orderBy = event.target.value
                let data = {
                    order_by: this.orderBy
                }
                let page = this.httpRequest('get', '/books', data)
            },
            async rearrangeBooks(event) {
                let i = 0
                if (!this.books) {
                    // If nothing to process, return
                    return
                }
                let sequence = this.books.map((book) => {
                    book.sort_order = i++
                    return book.id
                })
                let data = {
                    sequence: sequence,
                }
                this.page = this.httpRequest('post', '/books/rearrange/' + this.books[0].list_id , data)
            },
            async httpRequest(method, uri, data, ) {
                try {
                    await this.$inertia.visit(uri, {
                        method: method,
                        data: data,
                        replace: false,
                        preserveState: false,
                        preserveScroll: false,
                        only: [],
                        headers: {},
                        errorBag: null,
                        onSuccess: page => {},
                        onError: errors => {},
                        onFinish: () => {},
                    })
                } catch (ex) {
                }
            }

        },
        mounted() {},
        created() {}
    }
</script>
