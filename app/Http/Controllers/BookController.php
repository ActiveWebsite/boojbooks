<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;
use App\Book;

class BookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Book::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $orderby = 'position';
        $desc = filter_input(INPUT_GET, 'desc', FILTER_VALIDATE_BOOLEAN) === true ? true : false;
        
        switch (filter_input(INPUT_GET, 'orderby', FILTER_UNSAFE_RAW)) { # DETERMINE ORDERING
            case 'title':
                $orderby = 'title';
                break;
            case 'author':
                $orderby = 'author';
                break;
        }
        
        $books = Auth::user()->books()->orderBy($orderby, $desc ? 'desc' : 'asc')->get();
        
        return view('books.index')->with([
            'books'=>$books,
            'orderby'=>$orderby,
            'desc'=>$desc
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * 
     * @return Response
     */
    public function store(BookRequest $request)
    {
        $book = Auth::user()->books()->create($request->all());
        
        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $book->storeFormCover($request->file('cover'));
        }
        
        session()->flash('message', 'Successfully added new book!');
        return redirect('books');
    }

    /**
     * Display the specified resource.
     *
     * @param  Book  $book
     * 
     * @return Response
     */
    public function show(Book $book)
    {
        return view('books.show')->with([
            'imagePath'=>$book->getCoverPath(),
            'book'=>$book,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Book  $book
     * 
     * @return Response
     */
    public function edit(Book $book)
    {
        return view('books.edit')->with([
            'book'=>$book,
            'hasImage'=>$book->hasCover() ? true : false # DETERMINES WHETHER TO SHOW THE DELETE CHECKBOX
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Book  $book
     * @param  Request  $request
     * 
     * @return Response
     */
    public function update(Book $book, BookRequest $request)
    {
        $book->title = $request->input('title');
        $book->author = $request->input('author');
        $book->isbn13 = $request->input('isbn13');
        $book->publication_date = $request->input('publication_date');
        $book->save();
        
        if (filter_var($request->input('delete_cover'), FILTER_VALIDATE_BOOLEAN)) {
            $book->deleteCover();
        } else if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $book->storeFormCover($request->file('cover'));
        }
        
        session()->flash('message', 'Successfully modified ' . $book->title . '!');
        return $request->input('return') === 'books.show' ? redirect()->route('books.show', $book->id) : redirect()->route('books.index'); # RETURN TO BOOK'S PAGE OR BOOK INDEX
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Book  $book
     * 
     * @return Response
     */
    public function destroy(Book $book)
    {
        $title = $book->title;
        $book->delete();
        
        session()->flash('message', $title . ' has been removed from your list.');
        return redirect('books');
    }

    /**
     * Move resource up.
     *
     * @param  Book  $book
     * 
     * @return Response
     */
    public function moveup(Book $book)
    {
        $this->authorize('move', $book);
        $book->moveUp();
        
        return redirect('books');
    }

    /**
     * Move resource down.
     *
     * @param  Book  $book
     * 
     * @return Response
     */
    public function movedown(Book $book)
    {
        $this->authorize('move', $book);
        $book->moveDown();
        
        return redirect('books');
    }
}
