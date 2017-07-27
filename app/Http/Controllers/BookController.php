<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Book;

class BookController extends Controller
{
        
    /**
     * Book validation rules.
     *
     * @var array
     */
    protected $rules = [
        'title' => [
            'string',
            'required',
            'max:255'
        ],
        'author' => [
            'string',
            'required',
            'max:255',
            'regex:/.+, .+/' # AUTHORS MUST BE IN THE FORM LAST, FIRST
        ],
        'publication_date' => [
            'nullable',
            'date'
        ],
        'isbn13' => [
            'nullable',
            'size:13',
            'regex:/^\d*$/'
        ],
        'cover' => [
            'image',
            'mimetypes:image/gif,image/jpeg,image/png',
            'max:5000'
        ]
    ];
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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
        
        $books = Book::orderBy($orderby, $desc ? 'desc' : 'asc')->get();
        
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
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);
        
        $position = Auth::user()->countBooks(); # DEFAULT POSITION IS LAST
        
        # FIXME MINOR DRY VIOLATION, CONSOLIDATE IF APP BECOMES MORE COMPLEX
        $book = new Book;
        $book->user_id = Auth::user()->id;
        $book->title = filter_var($request->input('title'), FILTER_SANITIZE_STRING);
        $book->author = filter_var($request->input('author'), FILTER_SANITIZE_STRING);
        $book->isbn13 = filter_var($request->input('isbn13'), FILTER_SANITIZE_STRING);
        $book->publication_date = filter_var($request->input('publication_date'), FILTER_SANITIZE_STRING);
        $book->position = $position;
        $book->save();
        
        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $book->storeFormCover($request->file('cover'));
        }
        
        session()->flash('message', 'Successfully added new book!');
        return redirect('books');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * 
     * @return Response
     */
    public function show($id)
    {
        $book = Book::where('id', $id)->firstOrFail();
        
        return view('books.show')->with([
            'imagePath'=>$book->getCoverPath(),
            'book'=>$book,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * 
     * @return Response
     */
    public function edit($id)
    {
        $book = Book::where('id', $id)->firstOrFail();

        return view('books.edit')->with([
            'book'=>$book,
            'hasImage'=>$book->hasCover() ? true : false # DETERMINES WHETHER TO SHOW THE DELETE CHECKBOX
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param  Request  $request
     * 
     * @return Response
     */
    public function update($id, Request $request)
    {
        $this->validate($request, $this->rules);
        
        $book = Book::findOrFail($id);
        $book->title = filter_var($request->input('title'), FILTER_SANITIZE_STRING);
        $book->author = filter_var($request->input('author'), FILTER_SANITIZE_STRING);
        $book->isbn13 = filter_var($request->input('isbn13'), FILTER_SANITIZE_STRING);
        $book->publication_date = filter_var($request->input('publication_date'), FILTER_SANITIZE_STRING);
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
     * @param  int  $id
     * 
     * @return Response
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $title = $book->title;
        $book->delete();
        
        session()->flash('message', $title . ' has been removed from your list.');
        return redirect('books');
    }

    /**
     * Move resource up.
     *
     * @param  int  $id
     * 
     * @return Response
     */
    public function moveup($id)
    {
        $book = Book::findOrFail($id);
        $book->moveUp();
        
        return redirect('books');
    }

    /**
     * Move resource down.
     *
     * @param  int  $id
     * 
     * @return Response
     */
    public function movedown($id)
    {
        $book = Book::findOrFail($id);
        $book->moveDown();
        
        return redirect('books');
    }
}
