<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use App\Models\Book;

class BookController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'verified']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //return $request->user()->listings();
        /*
        return Inertia::render('Listing', [
            'listings' => $request->user()->listings()->get()
         ]);
         */
        return 'Books';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'title' => ['required'],
            'listing_id' => ['required']
        ])->validate();
        
        //$request->request->add(['user_id' => $request()->user()->id]);


        $book = new Book;
        $book->title = $request->title;
        $book->description = $request->description;
        $book->listing_id = $request->listing_id;
        $book->list_order = $request->list_order;
        $book->author = $request->author;
        $book->published = $request->published;
        $book->length = $request->length;
        $book->rating = $request->rating;
        $book->save();
  
        return redirect()->back()
                    ->with('message', 'Book Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        return Book::find($id);
        /*
        return Inertia::render('ListingDetail', [
            'listing' => Listing::get($id)
         ]);
        */
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'title' => ['required'],
        ])->validate();
  
        if ($request->has('id')) {
            Book::find($request->input('id'))->update($request->all());
            return redirect()->back()
                    ->with('message', 'Book Updated Successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->has('id')) {
            Book::find($request->input('id'))->delete();
            return redirect()->back()->with('message', 'Book Deleted Successfully.');
        }
    }
}
