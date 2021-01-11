<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card">
          <div class="card-header">Book list management</div>
          <div class="card-body">
            Here you can organize your personal book list.

            <div class="container">
              <div class="row justify-content-center">
                <div class="col-6">
                  <div class="card">
                    <div class="card-header">My Book List (click and drag to reorder list)</div>
                    <div class="card-body">
                      <div class="mt-3 mb-10">
                        Sort by:
                        <v-btn small @click="SortBy('title')" :color="sortedBy.search('title') > -1 ? 'red' : 'primary'"
                          >Title</v-btn
                        >
                        <v-btn
                          small
                          @click="SortBy('rating')"
                          :color="sortedBy.search('rating') > -1 ? 'red' : 'primary'"
                          >Rating</v-btn
                        >
                        <v-btn
                          small
                          @click="SortBy('pageCount')"
                          :color="sortedBy.search('pageCount') > -1 ? 'red' : 'primary'"
                          >Page Count</v-btn
                        >
                      </div>
                      <template v-if="books.length > 0">
                        <draggable v-model="books" @update="ReorderBooks" class="mt-2">
                          <v-row
                            v-for="(book, index) of books"
                            :key="index"
                            :class="(index % 2 ? 'red lighten-5' : 'deep-purple lighten-4') + ' m-0'"
                          >
                            <v-col cols="3" class="p-1">
                              <v-img
                                contain
                                max-height="120"
                                v-if="book.image.length > 0"
                                :src="book.image"
                                alt="asdf"
                              />
                            </v-col>
                            <v-col cols="7" align-self="center">
                              <v-container>
                                <v-row>
                                  {{ book.title }}
                                </v-row>
                                <v-row class="mt-3"> Rating: {{ book.rating }} <v-icon>mdi-star</v-icon> </v-row>
                                <v-row class="mt-3"> Page Count: {{ book.pageCount }} </v-row>
                              </v-container>
                            </v-col>
                            <v-col cols="2" align-self="center"
                              ><v-btn @click="RemoveBook(book)" color="red accent-1">Remove</v-btn></v-col
                            >
                          </v-row>
                        </draggable>
                      </template>
                      <template v-else> No books in list </template>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="card">
                    <div class="card-header">Search New Books</div>
                    <div class="card-body">
                      <v-text-field
                        v-model="bookSearch"
                        label="Book Name"
                        outlined
                        append-outer-icon="mdi-send"
                        @click:append-outer="SearchBook"
                        @keydown.enter="SearchBook"
                      />

                      <v-container v-if="apiResults">
                        <v-row
                          v-for="(book, index) of apiResults.items"
                          :key="index"
                          :class="(index % 2 ? 'red lighten-5' : 'deep-purple lighten-4') + ' m-0'"
                        >
                          <v-col cols="7" align-self="center">
                            <v-container>
                              <v-row>
                                {{ book.volumeInfo.title }}
                              </v-row>
                              <v-row class="mt-3">
                                Rating: {{ book.volumeInfo.averageRating }} <v-icon>mdi-star</v-icon>
                              </v-row>
                              <v-row class="mt-3"> Page Count: {{ book.volumeInfo.pageCount }} </v-row>
                            </v-container>
                          </v-col>
                          <v-col cols="3" class="p-1">
                            <v-img
                              contain
                              v-if="book.volumeInfo.imageLinks && book.volumeInfo.imageLinks.smallThumbnail"
                              max-height="120"
                              :src="book.volumeInfo.imageLinks.smallThumbnail"
                            />
                          </v-col>
                          <v-col cols="2" align-self="center">
                            <v-btn @click="AddBook(book)" color="info">Add</v-btn>
                          </v-col>
                        </v-row>

                        <div v-if="apiResults.totalItems > 5" class="mt-4 d-flex justify-space-between">
                          <v-btn color="info" @click="ModifyIndex(-5)" :disabled="startIndex === 0 ? true : false">
                            &lt; Prev 5
                          </v-btn>

                          <v-btn
                            color="info"
                            @click="ModifyIndex(5)"
                            :disabled="apiResults.totalItems - 5 <= startIndex ? true : false"
                          >
                            Next 5 &gt;
                          </v-btn>
                        </div>
                      </v-container>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import http from '~/services/HttpService';
import { Book, IndustryIdentifier, VolumeInfo, AccessInfo, ApiBook, ApiResult } from '~/types/Book';
import draggable from 'vuedraggable';

@Component({
  components: {
    draggable,
  },
})
export default class BookList extends Vue {
  private books: Book[];
  private apiResults: ApiResult | null = null;
  private bookSearch: string = '';
  private searchQuery: string = '';
  private startIndex: number = 0;
  private sortedBy: string = '';

  constructor() {
    super();
    this.books = [];
  }

  private ModifyIndex(offset: number) {
    this.startIndex += offset;
    this.DoSearch();
  }

  // error 422 on malformed request
  private async AddBook(book: ApiBook) {
    let img: string = '';
    if (book.volumeInfo.imageLinks && book.volumeInfo.imageLinks.smallThumbnail)
      img = book.volumeInfo.imageLinks?.smallThumbnail;
    try {
      const result = await http.put('/books', {
        title: book.volumeInfo.title,
        id: book.id,
        pageCount: book.volumeInfo.pageCount ? book.volumeInfo.pageCount : 0,
        rating: book.volumeInfo.averageRating ? book.volumeInfo.averageRating : 0,
        image: img,
      });
      if (result.data) {
        this.books.push(result.data);
      }
    } catch (ex) {
      if (ex.response.status === 422) {
        // shouldn't happen, can't add book to list
      }
    }
  }

  private async RemoveBook(book: Book) {
    let img: string = '';
    try {
      await http.delete(`/books/${book.book_id}`);
      this.books = this.books.filter((value: Book) => {
        if (value.book_id === book.book_id) {
          return false;
        }
        return true;
      });
    } catch (ex) {
      if (ex.response.status === 422) {
        // shouldn't happen, can't delete book
      }
    }
  }

  private async GetBooks() {
    const result = await http.get('/books');
    if (result.data) {
      this.books = result.data;
      this.books.sort((a: Book, b: Book) => {
        return a.order - b.order;
      });
    }
  }

  private async ReorderBooks() {
    let v = 0;
    if (!this.books) {
      return;
    }
    await http.post(
      '/books',
      this.books.map((value: Book) => {
        value.order = v++;
        return { ...value };
      }),
    );
  }

  private SortBy(field: string) {
    if (this.sortedBy === field) {
      this.sortedBy = `-${field}`;
      this.books = this.books.sort((a: any, b: any) => {
        if (typeof b[field] === 'string') {
          return (b[field] as string).localeCompare(a[field]);
        }
        return b[field] - a[field];
      });
    } else {
      this.sortedBy = field;
      this.books = this.books.sort((a: any, b: any) => {
        if (typeof a[field] === 'string') {
          return (a[field] as string).localeCompare(b[field]);
        }
        return a[field] - b[field];
      });
    }
  }

  private async SearchBook() {
    if (this.bookSearch.length == 0) {
      // error
    }
    this.searchQuery = this.bookSearch;
    this.startIndex = 0;
    await this.DoSearch();
  }

  private async DoSearch() {
    try {
      const result = await http.get(
        `https://www.googleapis.com/books/v1/volumes?startIndex=${this.startIndex}&maxResults=5&q=${encodeURIComponent(
          this.searchQuery,
        )}`,
      );
      this.apiResults = result.data;
      if (!this.apiResults) {
        // error
        return;
      }
    } catch (ex) {
      // error
    }
  }

  private mounted() {
    this.GetBooks();
  }
}
</script>
