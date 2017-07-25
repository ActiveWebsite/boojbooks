<?php

namespace App\Http\Controllers;

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
            'required'
        ],
        'author' => [
            'required',
            'regex:/.+, .+/'
        ],
        'publication_date' => [],
        'isbn13' => [
            'present',
            'nullable',
            'size:13',
            'regex:/^\d*$/'
        ],
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
        $user = \Auth::user();
        
        $orderby = 'position';
        $desc = filter_input(INPUT_GET, 'desc', FILTER_VALIDATE_BOOLEAN) === true ? true : false;
        
        switch (filter_input(INPUT_GET, 'orderby', FILTER_UNSAFE_RAW)) {
            case 'title':
                $orderby = 'title';
                break;
            case 'author':
                $orderby = 'author';
                break;
        }
        
        $books = $user->books()->orderBy($orderby, $desc ? 'desc' : 'asc')->get();
        
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
        
        $position = \Auth::user()->countBooks();
        
        $book = new Book;
        $book->title = filter_var($request->input('title'), FILTER_SANITIZE_STRING);
        $book->author = filter_var($request->input('author'), FILTER_SANITIZE_STRING);
        $book->position = $position;
        $book->isbn13 = $request->input('isbn13');
        $book->publication_date = $request->input('publication_date');
        $book->user_id = auth()->user()->id;
        $book->save();
        
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
        $user = \Auth::user();
        $book = $user->books()->where('id', $id)->firstOrFail();

        return view('books.show')->with([
            'book'=>$book
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
        $user = \Auth::user();
        $book = $user->books()->where('id', $id)->firstOrFail();

        return view('books.edit')->with([
            'book'=>$book,
            'message'=>session()->get('message')
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
        
        $user = \Auth::user();
        $book = $user->books()->where('id', $id)->firstOrFail();
        
        $book->title = filter_var($request->input('title'), FILTER_SANITIZE_STRING);
        $book->author = filter_var($request->input('author'), FILTER_SANITIZE_STRING);
        $book->isbn13 = $request->input('isbn13');
        $book->publication_date = $request->input('publication_date');
        $book->save();
        
        session()->flash('message', 'Successfully modified ' . $book->title . '!');
        return redirect('books');
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
        $user = \Auth::user();
        $book = $user->books()->where('id', $id)->firstOrFail();
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
        $user = \Auth::user();
        
        $book = $user->books()->where('id', $id)->firstOrFail();
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
        $user = \Auth::user();
        
        $book = $user->books()->where('id', $id)->firstOrFail();
        $book->moveDown();
        
        return redirect('books');
    }
}
