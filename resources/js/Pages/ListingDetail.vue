<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ listing.name }}
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
          <div
            class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
            role="alert"
            v-if="$page.props.flash.message || $page.props.errors.title"
          >
            <div class="flex">
              <div>
                <p class="text-sm">
                  {{ $page.props.flash.message }} {{ $page.props.errors.title }}
                </p>
              </div>
            </div>
          </div>
          <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search"
            single-line
            hide-details
          ></v-text-field>
          <v-data-table
            :headers="headers"
            :items="books"
            loading
            loading-text="loading"
            item-key="id"
            :show-select="false"
            :disable-pagination="true"
            :hide-default-footer="true"
            :search="search"
            class="page__table"
            @update:sort-by="
              (item1) => {
                sort = item1.length;
              }
            "
          >
            <template v-slot:body="props">
              <draggable
                :list="props.items"
                tag="tbody"
                :disabled="!draggable"
                :move="onMoveCallback"
              >
                <tr v-for="(book, index) in props.items" :key="index">
                  <td>
                    <DragWidget :book="book" :order="index" :active="draggable" />
                  </td>
                  <td>{{ book.title }}</td>
                  <td>{{ book.description }}</td>
                  <td>{{ book.author }}</td>
                  <td>{{ book.published }}</td>
                  <td>{{ book.length }}</td>
                  <td>{{ book.rating }}</td>
                  <td>
                    <v-icon small @click="edit(book)"> mdi-pencil </v-icon>
                    <v-icon small @click="deleteItem(book)"> mdi-delete </v-icon>
                    <a :href="`/listing/${listing.id}/book/${book.id}`">
                      <v-icon small @click="">mdi-dots-horizontal</v-icon>
                    </a>
                  </td>
                </tr>
              </draggable>
            </template>
          </v-data-table>
          <button
            @click="openModal()"
            type="button"
            class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5"
          >
            <v-icon>mdi-plus</v-icon> Add Book
          </button>
          <div
            class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400"
            v-if="isOpen"
          >
            <div
              class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0"
            >
              <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
              </div>
              <!-- This element is to trick the browser into centering the modal contents. -->
              <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
              <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                role="dialog"
                aria-modal="true"
                aria-labelledby="modal-headline"
              >
                <form>
                  <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="">
                      <div class="mb-4">
                        <v-form ref="form" v-model="valid" lazy-validation>
                          <v-text-field
                            v-model="form.title"
                            label="Book Title"
                            :rules="nameRules"
                          ></v-text-field>

                          <v-text-field
                            v-model="form.description"
                            label="Description"
                            :rules="nameRules"
                          ></v-text-field>

                          <v-text-field
                            v-model="form.author"
                            label="Author"
                          ></v-text-field>

                          <v-text-field
                            v-model="form.rating"
                            type="number"
                            label="Rating"
                          ></v-text-field>

                          <v-text-field
                            v-model="form.length"
                            type="number"
                            label="Page Length"
                          ></v-text-field>
                        </v-form>
                      </div>
                    </div>
                  </div>
                  <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                      <button
                        wire:click.prevent="store()"
                        type="button"
                        class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                        v-show="!editMode"
                        @click="save(form)"
                      >
                        Save
                      </button>
                    </span>
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                      <button
                        wire:click.prevent="store()"
                        type="button"
                        class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                        v-show="editMode"
                        @click="update(form)"
                      >
                        Update
                      </button>
                    </span>
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                      <button
                        @click="closeModal()"
                        type="button"
                        class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                      >
                        Cancel
                      </button>
                    </span>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import ListingCard from "@/Components/ListingCard";
import DragWidget from "@/Components/DragWidget";
import Draggable from "vuedraggable";

export default {
  props: ["listing", "books", "errors"],

  components: {
    AppLayout,
    ListingCard,
    Draggable,
    DragWidget,
  },

  data() {
    return {
      valid: true,
      dateFormatted: new Date().toISOString().substr(0, 10),
      menu: false,
      menu1: false,
      modal: false,
      menu2: false,
      name: "",
      nameRules: [
        (v) => !!v || "Required",
        (v) => (v && v.length <= 100) || "Must be less than 100 characters",
      ],
      select: null,
      items: [1, 2, 3, 4, 5],
      search: "",
      sort: 0,
      editMode: false,
      isOpen: false,
      loading: false,
      form: this.$inertia.form(
        {
          id: null,
          title: null,
          description: null,
          listing_id: this.listing.id,
          author: null,
          published: null,
          length: null,
          rating: null,
          list_order: 0,
        },
        {
          resetOnSuccess: true,
        }
      ),
      headers: [
        { text: " ", sortable: false },
        { text: "Name", value: "title", sortable: true, filterable: true },
        {
          text: "Description",
          value: "description",
          sortable: true,
          filterable: true,
        },
        {
          text: "Author",
          value: "description",
          sortable: true,
          filterable: true,
        },
        {
          text: "Published",
          value: "description",
          sortable: true,
          filterable: true,
        },
        {
          text: "Length",
          value: "description",
          sortable: true,
          filterable: true,
        },
        { text: "Rating", sortable: true, sortable: true, filteerable: true },
        { text: "Action", sortable: false },
      ],
    };
  },

  computed: {
    draggable: function () {
      if (this.sort > 0 || this.search.length > 0) {
        return false;
      }
      return true;
    },
  },
  methods: {
    openModal: function () {
      this.isOpen = true;
    },
    closeModal: function () {
      this.isOpen = false;
      this.reset();
      this.editMode = false;
    },
    reset: function () {
      this.form = {
        title: null,
        description: null,
        listing_id: this.listing.id,
        list_order: 0,
      };
    },
    save: function (data) {
      //  this.$inertia.post('/book', data)
      // this.reset();
      this.form.list_order = this.books.length;
      console.log("list order");

      this.form.post("/book", {
        preserveScroll: true,
      });

      //this.$inertia.post("/book", this.form);
      this.closeModal();
      this.editMode = false;
    },
    edit: function (data) {
      console.log(this.form);
      this.form = Object.assign(this.form, data);
      // this.form.id = data.id;
      // this.form.title = data.title;
      // this.form.desscription = data.description;
      console.log(this.form);
      this.editMode = true;
      this.openModal();
    },
    update: function (data) {
      /*
                data._method = 'PUT';
                this.$inertia.post('/book/' + data.id, data)
                this.reset();
                this.closeModal();
              */
      console.log(this.form.id);
      this.form.put("/book/" + this.form.id, {
        preserveScroll: true,
      });
      this.closeModal();
    },
    deleteItem: function (data) {
      if (!confirm("Are you sure want to remove?")) return;
      data._method = "DELETE";
      this.$inertia.post("/book/" + data.id, data);
      //this.reset();
      this.closeModal();
    },
    onMoveCallback: function (evt, originalEvent) {
      return;
    },
    validate() {
      console.log(this.$refs.form.validate());
      this.$refs.form.validate();
    },
    reset() {
      this.$refs.form.reset();
    },
    resetValidation() {
      this.$refs.form.resetValidation();
    },
  },
};
</script>
