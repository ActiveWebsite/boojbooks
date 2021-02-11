<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use App\Models\Book;
use App\Models\Listing;

class ApiBookController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'verified', 'has_owner']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Listing $listing)
    {
        return $listing->books()->get();
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Listing $listing)
    {

        $v = Validator::make($request->all(), [
            'title' => ['required'],
            'description' => ['required'],
        ]);
        
        if ($v->fails()){
            return response()->json(['errors' => $v->errors()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        if(!$listing->id){
            abort(404);
        }
        
        //$request->request->add(['user_id' => $request()->user()->id]);


        $book = new Book;
        $book->title = $request->title;
        $book->description = $request->description;
        $book->listing_id = $listing->id;
        $book->list_order = ($request->list_order) ? $request->list_order : $listing->books()->count();
        $book->author = $request->author;
        $book->published = $request->published;
        $book->length = $request->length;
        $book->rating = $request->rating;
        $book->save();
  
        return $book;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Listing $listing, Book $book)
    {
        if($listing && $book && $book->listing_id != $listing->id){
            abort(404);
        }

        return $book;
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Listing $listing, Book $book)
    {

        $v = Validator::make($request->all(), [
            'title' => ['required'],
        ]);
  
        if ($v->fails()){
            return response()->json(['errors' => $v->errors()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $book->update($request->all());
        return $book;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Listing $listing, Book $book)
    {
        return $book->delete();
    }
}
