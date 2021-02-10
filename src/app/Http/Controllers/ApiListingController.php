<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use App\Models\Listing;
use App\Models\Book;

class ApiListingController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'verified', 'has_owner']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $request->user()->listings()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => ['required'],
        ]);
        
        if ($v->fails()){
            return response()->json(['errors' => $v->errors()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        //$request->request->add(['user_id' => $request()->user()->id]);

        $listing = new Listing;
        $listing->name = $request->name;
        $listing->user_id = $request->user()->id;
        $listing->save();
  
        return $listing;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Listing $listing)
    {   

        return $listing;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Listing $listing)
    {
        $v = Validator::make($request->all(), [
            'name' => ['required'],
        ]);

        if ($v->fails()){
            return response()->json(['errors' => $v->errors()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
  
        $listing->update($request->all());

        return $listing;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Listing $listing)
    {
        return $listing->delete();
    }

}
