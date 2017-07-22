<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){
        $user = \Auth::user();
        $books = $user->books()->orderBy('position','desc')->get();
        
        return view('books.index')->with('books', $books);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(){
        return view('books.edit')->with('new',true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * 
     * @return Response
     */
    public function store(Request $request){
        $rules = [
            'title' => 'required',
            'author' => 'required',
            'isbn13' => 'present|size:13|nullable|regex:/^\d*$/'
        ];
        
        $this->validate($request,$rules);
        
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
    public function show($id){ # TODO
        /*$book = Book::find($id);

        if(!$book){
            return abort(404);
        }

        return view('books.view')->with([
            'id'=>$id,
            'title'=>$book->title,
            'author'=>$book->author,
            'isbn13'=>$book->isbn13,
            'publication_date'=>$book->publication_date,
            'created'=>$book->created_at,
            'message'=>session()->get('message')
        ]);*/
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * 
     * @return Response
     */
    public function edit($id){ # TODO
        $book = Book::find($id);

        if(!$book){
            return abort(404);
        }

        return view('books.edit')->with([
            'new'=>false,
            'id'=>$id,
            'title'=>$book->title,
            'author'=>$book->author,
            'isbn13'=>$book->isbn13,
            'publication_date'=>$book->publication_date,
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
    public function update($id, Request $request){ # TODO
        /*if($request->input('topic_add')){ //ADDING A TOPIC
                $page = Page::find($id);

                $topic = Topic::findby($request->input('topic_add'));
                $page->topics()->attach($topic->id);
        } else if($request->input('topic_remove')){ //REMOVING A TOPIC
                $page = Page::find($id);

                $topic = Topic::findby($request->input('topic_remove'));
                $page->topics()->detach($topic->id);
        } else { //UPDATING THE PAGE BODY
                $this->validate($request,[
                        'name' => 'required|max:64',
                        'body' => 'required'
                ]);

                DB::beginTransaction();
                $page = Page::find($id);
                $page->name = $request->input('name');
                $page->save();

                $draft = new PageDraft();
                $draft->page = $id;
                $draft->type = empty($request->input('draft')) ? 'published' : 'draft';
                $draft->body = $request->input('body'); //PARSE !!!
                $draft->save();
                DB::commit();
        }

        session()->flash('message', 'Successfully updated topic!');
        return redirect('topics/'.str_replace(' ','-',$request->input('name')));*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * 
     * @return Response
     */
    public function destroy($id){ # TODO
        
    }
}
