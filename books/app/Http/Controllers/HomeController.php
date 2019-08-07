<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware ( 'auth' );
	}
	
	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		$sort = $request->input ( 'sort' );
		$by = $request->input ( 'desc' );
		// Get the currently authenticated user...
		$user = Auth::user ();
		// Get the currently authenticated user's ID...
		$id = Auth::id ();
		$order = 'order';
		$desc = 'asc';
		if ($sort == 'author')
			$order = $sort;
		if ($by == 'desc')
			$desc = $by;
		
		$books = \App\Books::where ( 'users_id', $id )->orderBy ( $order, $desc )->get ();
		if ($desc == 'asc')
			$desc = 'desc';
		else
			$desc = 'asc';
		return view ( 'home', [ 
				'books' => $books,
				'desc' => $desc 
		] );
	}
	public function delete($id) {
		if ($id > 0) {
			$book = \App\Books::find ( $id );
			$book->delete ();
		}
		return redirect ()->route ( 'home' );
	}
	public function move($move, $id) {
		$allowedVal = array (
				'up',
				'down' 
		);
		
		if ($id > 0 && in_array ( $move, $allowedVal )) {
			$book = \App\Books::find ( $id );
			$currentOrder = $book->order;
			if ($move == 'up') {
				$nextBook = \App\Books::where ( 'order', '<', $book->order )->orderBy ( 'order', 'desc' )->first ();
			} else {
				$nextBook = \App\Books::where ( 'order', '>', $book->order )->orderBy ( 'order', 'asc' )->first ();
			}
			if (isset ( $nextBook->order )) {
				echo $nextBook->order;
				$book->order = $nextBook->order;
				$nextBook->order = $currentOrder;
				$book->save ();
				$nextBook->save ();
			}
		}
		return redirect ()->route ( 'home' );
	}
	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function add() {
		return view ( 'add' );
	}
	
	/**
	 * Create a new book.
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function save(Request $request) {
		// Validate the request...
		$book = new \App\Books ();
		
		$book->author = $request->author;
		$book->title = $request->title;
		$date = strtotime ( $request->publication_date );
		$book->publication_date = date ( 'Y-m-d', $date );
		
		// Get the currently authenticated user...
		$user = Auth::user ();
		// Get the currently authenticated user's ID...
		$id = Auth::id ();
		$book->users_id = $id;
		$book->order = \App\Books::max ( 'order' ) + 1;
		$book->save ();
		return redirect ()->route ( 'home' );
	}
}
