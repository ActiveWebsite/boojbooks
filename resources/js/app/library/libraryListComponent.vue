<template>
    <!--Grid row-->
    <div class="row">

        <!--Cloud Library IT Books List-->
        <div class="col-lg-8">
            <!-- Card -->
            <div class="mb-3 shadow">
                <div class="card-body">
                    <h5 class="mb-4">Cloud Library IT Books <span class="text-muted small">(api.itbook.store)</span></h5>


                    <div class="row" ><!-- row require for flex  -->

                        <!-- Component looping each Book Info -->
                        <div class="col-md-3 mb-3" v-for="(book, key) in books" :key="key">
                            <div class="card pt-2">
                                <div class="text-center">
                                    <img class="img-fluid w-55 justify-content-center"
                                     :src="book.image"
                                     alt="Sample">
                                </div>
                                <div class="text-left">
                                    <p class="mb-1 ml-2 text-muted small">{{ book.title }}</p>
                                    <br v-if="book.title.length < 26">
                                </div>
                                <div class="row text-center mx-2 mb-2">
                                    <button class="btn btn-primary btn-sm btn-block" v-b-modal="'myModal'" @click="sendInfo(book)">See Details&nbsp;<ion-icon name="eye-outline" class="mt-1"></ion-icon></button>
                                    <button class="btn btn-success btn-sm btn-block" @click="addBookToList(book, key)">Add to List&nbsp;<ion-icon name="add-circle-outline" class="mt-1"></ion-icon></button>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div> <!-- End Cloud List -->



        <!-- My Library List -->
        <div class="col-lg-4">
            <div class="card mb-3 shadow sticky">
                <div class="card-body">
                    <h5 class="mb-3">Your Reading List</h5>
                    <!-- Dragable List-->
                    <draggable
                        tag="ul"
                        :list="list"
                        class="list-group"
                        handle=".handle"
                        v-bind="dragOptions"
                        @start="drag = true"
                        @end="drag = false"
                        >
                        <li class="list-group-item" v-for="(element, idx) in list" :key="element.name">
                            <div class='row inline align-items-bottom justify-content-between'>
                                <div class='row align-items-bottom justify-content-start ml-1'>
                                    <ion-icon name="move-outline" style="color:gray; font-size: 16px;" class="handle"></ion-icon><p class="small pt-1 mb-0">&nbsp;{{ element.title }}</p>
                                </div>
                                <ion-icon name="trash-outline" style="color:red; font-size: 24px;" class="" @click="removeAt(idx)"></ion-icon>
                            </div>
                        </li>
                        <li class="list-group-item" v-if="list.length == 0">
                            No Books Added to the list ! <ion-icon name="beer" style="color:gray; font-size: 24px;"  ></ion-icon>
                        </li>
                    </draggable>

                    <!-- Actions Buttons -->
                    <div class="row justify-content-between mt-2">
                        <div class="col-6 pl-3">
                            <button type="button" class="btn btn-primary btn-block" @click="sort"><span class="small">Sort Added Order</span></button>
                        </div>
                        <div class="col-6 pr-3">
                            <button type="button" class="btn btn-primary btn-block" @click="savingList">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--End My Library List-->


    <!-- Modal Info Details-->  
    <b-modal id="myModal" title="Details Info"  size="lg">
        <div class="media">
        <a class="pull-left" href="#">
            <img class="img-fluid w-60 justify-content-center"
                    :src="selectedBook.image"
                    alt="Sample">
        </a>
        <div class="media-body">
            <h4 class="media-heading">{{selectedBook.title}}</h4>
                <div class="text-left">
                <p class="mb-1"><strong>Title:</strong> {{ selectedBook.title }}</p>
                <p class="mb-1"><strong>Description:</strong> {{ selectedBook.subtitle }}</p>
                <p class="mb-1"><strong>isbn13:</strong> {{ selectedBook.isbn13 }}</p>
                <p class="mb-1"><strong>price:</strong> {{ selectedBook.price }}</p>
                <p class="mb-1"><strong>Link:</strong> <a :href="selectedBook.url" target="_blank"> {{ selectedBook.url }}</a> </p>
                </div>
        </div>
        </div>
    </b-modal>

    </div>
    <!--End Grid row-->

</template>

<script>

    let order = 1;
    import draggable from 'vuedraggable'
    export default {
        props: ['user_id'],
        name: "Library_Book",
        instruction: "Drag using the handle icon",
        order: 5,
        components: {
            draggable,
        },
        data: function () {
            return {
                csrf: document.head.querySelector('meta[name="csrf-token"]').content,

                loading_books:false,
                loading_list:false,
                showModal:false,
                dragging: false,
                selectedBook: '',

                books : {},
                list: [],

            }
        },
        computed: {
            draggingInfo() {
                return this.dragging ? "under drag" : "";
            },
            dragOptions() {
                return {
                    animation: 200,
                    group: "description",
                    disabled: false,
                    ghostClass: "ghost"
                };
            }
        },
        methods: {
            savingList() {
                console.log('Saving Reading List...');
                axios.post('/api/set-list', {
                        data   : this.list,
                        user_id: this.user_id
                    })
                    .then(function(response) {
                        console.log('Reading List Updated: ' + response.data);
                        // Display a success toast, with a title
                        toastr.success('Your Reading List has been saved!', 'Congratulations', {timeOut: 5000})
                    })
                    .catch(function(error) {
                        
                        let error_message = 'Fail Saving Reading List some information are not right'

                        if (typeof(error.response.data.message) != 'undefined') {
                            console.log(' error.response.data.message is defined');
                            if(error.response.data.message){
                                error_message = error.response.data.message
                            }
                        }
                        //this.creating_appointment = false
                    
                        toastr.error(error_message, 'Error Alert', {timeOut: 5000});
                    }
                );    
            },
            sendInfo(book) {
                this.selectedBook = book;
            },
            async fetchBooksFromAPI(){

                const baseURL = 'https://api.itbook.store/1.0/new';
                this.loading_books = true

                axios.get('/api/books/')
                    .then((response) => {
                        this.books = response.data.books;
                        this.loading_books = false
                    });
            },
            async fetchUsersLibrary(){

                const baseURL = '/api/get-user-list/';
                this.loading_list = true

                axios.get('/api/get-user-list/'+this.user_id)
                    .then((response) => {
                        console.log(response.data);
                        this.list = response.data;
                        this.loading_list = false
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            addBookToList(book){

                    let casio = this.isValueInList(this.list, book);
                    console.log(casio);

                    if(casio){
                        toastr.error('Book already in List', 'Error Alert !', {timeOut: 5000})
                        return false;
                    }else{

                        this.list.push({
                            title   : book.title,
                            subtitle: book.subtitle,
                            isbn13  : book.isbn13,
                            price   : book.price,
                            image   : book.image,
                            url     : book.url,
                            order   : this.calculateNextOrderID(this.list),
                        });
                    }

            },
            isValueInList(library_list, book) {

                for (var i = 0; i < library_list.length; i++) {

                    if( (library_list[i].isbn13) === (book.isbn13)) {
                        console.log('is the same');
                        return true;
                    }
                }
                return false;
            },
            removeAt(idx) {
                this.list.splice(idx, 1);
            },
            sort() {
                this.list = this.list.sort((a, b) => a.order - b.order);
            },

            calculateNextOrderID(library_list){
                let max = 0;
                for (var i = 0; i < library_list.length; i++) {

                    if( (library_list[i].order) > max) {
                        max = library_list[i].order;
                    }
                }
                return max+1;
            },

        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            this.fetchBooksFromAPI();
            this.fetchUsersLibrary();
            console.log( 'user_id' + this.user_id);
        }
    }
</script>

<style scoped>
.handle {
  float: left;
  padding-top: 4px;
  padding-bottom: 4px;
  cursor: pointer;
}

.close {
  float: right;
  padding-top: 8px;
  padding-bottom: 8px;
}

.flip-list-move {
  transition: transform 0.5s;
}
.no-move {
  transition: transform 0s;
}
.ghost {
  opacity: 0.5;
  background: #c8ebfb;
}


</style>
