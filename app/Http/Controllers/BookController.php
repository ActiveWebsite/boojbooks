<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookList;
use App\Models\Genre;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use Inertia\Inertia;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return array[]|\Inertia\Response
     * @throws ValidationException
     */
    public function index(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'order_by' => 'sometimes | string'
        ]);
        $validated = $validator->validated();

        if(isset($validated['order_by']) && $validated['order_by'] === "") {
            unset($validated['order_by']);
        }
        $data = ['books' => $this->getBooksList($validated)];
        if( request()->is('api/*')) {
            return ['data' => $data];
        }else {
            return Inertia::render('Book', $data);
        }
    }

    /**
     * Endpoint to rearrange the sequence of books in the list
     * @param Request $request
     * @param BookList $bookList
     * @return array[]|\Inertia\Response
     * @throws ValidationException
     */
    public function rearrange(Request $request, BookList $bookList) {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'sequence' => 'required | array',
        ]);
        $validated = $validator->validated();

        if(isset($validated['sequence'])) {
            $i  = 0;
            foreach ($validated['sequence'] as $book_id) {
                DB::statement("UPDATE list_books SET sort_order = {$i} where book_id={$book_id} AND list_id = {$bookList->id}");
                $i++;
            }
        }
        $data = ['books' => $this->getBooksList()];
        if( request()->is('api/*')) {
            return ['data' => $data];
        }else {
            return Inertia::render('Book', $data);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return array[]|\Inertia\Response
     */
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;

        // Validation Rules
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'unique_id' => 'required | string',
            'title' => 'required | string',
            'description' => 'sometimes | string',
            'authors' => 'sometimes | array',
            'genres' => 'sometimes | array',
            'rating' => 'sometimes | numeric',
            'publisher' => 'sometimes | string',
            'publication_date' => 'sometimes | string',// Sometimes it comes YYYY only
            'cover_image' => 'sometimes | string',
            'cover_image_small' => 'sometimes | string',
            'order_by' => 'sometimes | string'
        ]);
        try{
            $validated = $validator->validated();
        }catch(\Exception $e) {
            return ['data'=>['error'=> $e->getMessage()]];
        }

        if($validator->errors()->messages()) {
            return ['data'=>['error'=> $validator->errors()->messages()]];
        }else
        if($validator->passes()){
            // Get a List for books.  For now "Default" is the list.
            //TODO: Multiple lists for a user
            $bookListName = "Default";
            $bookList =  BookList::query();
            if($bookListName) {
                $bookList = $this->getBookList($bookListName);
            }

            // Save/Update Book
            $book = Book::firstOrNew(array('title' => $validated['title'], 'unique_id' => $validated['unique_id'], 'user_id' => $user_id));
            $book->cover_image = $validated['cover_image'] ?? null;
            $book->cover_image_small = $validated['cover_image_small'] ?? null;
            $book->rating = $validated['rating'] ?? null;
            $book->publisher = $validated['publisher'] ?? null;
            $book->publication_date = $validated['publication_date'] ?? null;
            $book->description = $validated['description'] ?? null;
            $book->save();

            // Genre
            if(isset($validated['genres'])) {
                foreach ($validated['genres'] as $genreName) {
                    $genre = $this->getGenre($genreName);
                    $book->genres()->syncWithoutDetaching($genre);
                }
            }

            // Author
            if(isset($validated['authors'])) {
                foreach ($validated['authors'] as $authorName) {
                    $author = $this->getAuthor($authorName);
                    $book->authors()->syncWithoutDetaching($author);
                }
            }

            // Update List
            if(!$book->lists->contains($bookList)) {
                $book->lists()->attach($bookList);
            }

            $data = ['books' => $this->getBooksList($validated)];
            if( request()->is('api/*')) {
                return ['data' => $data];
            }else {
                return Inertia::render('Book', $data);
            }
        }
    }


    /**
     * Display the specified resource.
     *
     * @param Book $book
     * @return array[]|\Inertia\Response
     */
    public function show(Book $book)
    {
        $user_id = Auth::user()->id;

        //Fetch Book "with" details
        $book = Book::
        select('books.*')
            ->where('books.id', '=', $book->id)
            ->where('books.user_id', '=', $user_id)
            ->with('authors', function ($query){
                $query->select('name');
            })
            ->with('genres', function ($query){
                $query->select('name');
            })
            ->first();
        $data = ['book' => $book];
        if( request()->is('api/*')) {
            return ['data' => $data];
        }else {
            return Inertia::render('BookDetails', $data);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return array[]|\Inertia\Response
     */
    public function destroy(Request $request)
    {
        $user_id = Auth::user()->id;
        Book::where('id', '=', $request->id)
            ->where('user_id', '=', $user_id)
            ->delete();

        $data = ['books' => $this->getBooksList()];
        if( request()->is('api/*')) {
            return ['data' => $data];
        }else {
            return Inertia::render('Book', $data);
        }
    }

    /**
     * @param null $data
     * @return mixed
     */
    private function getBooksList($data = null) {
        $orderBy = 'list_books.sort_order asc, books.id desc';
        if(isset($data['order_by']))  {
            $orderBy = $data['order_by'];
        }
        $user_id  = Auth::user()->id;
        $data = Book::select('books.*', 'list_books.list_id', 'list_books.sort_order')
            ->join('list_books', 'books.id', '=', 'list_books.book_id')
            ->join('lists', 'lists.id', '=', 'list_books.list_id')
            ->where('lists.user_id', '=', $user_id)
            ->with('authors', function ($query){
                $query->select('name');
            })
            ->with('genres', function ($query){
                $query->select('name');
            })
            ->orderByRaw($orderBy)
            ->get();
//        print_r(DB::getQuerylog());
        return $data ;
    }

    /**
     * @param $name
     * @return Author
     */
    private function getAuthor($name): Author {
        return $this->modelFirstOrNewByName(Author::class, $name);
    }

    /**
     * @param $name
     * @return Genre
     */
    private function getGenre($name): Genre {
        return $this->modelFirstOrNewByName(Genre::class, $name);
    }

    /**
     * @param $name
     * @return BookList
     */
    private function getBookList($name): BookList {
        return $this->modelFirstOrNewByName(BookList::class, $name);
    }

    /**
     * @param $modelName
     * @param $name
     * @return mixed
     */
    private function modelFirstOrNewByName($modelName, $name) {
        $model = $modelName::firstOrNew(array('name' => $name, 'user_id'=>Auth::user()->id));
        $model->save();
        return $model;
    }
}
