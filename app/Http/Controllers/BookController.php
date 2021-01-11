<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * @param Request $request
     */
    public function add(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => 'required',
            'title' => 'required',
        ]);

        $book = $request->all();

        $count = Book::where('owner_id', Auth::user()->id)->where('book_id', $book['id'])->count();
        if (Book::where('owner_id', Auth::user()->id)->where('book_id', $book['id'])->count() > 0)
        {
            return response()->json('', 422);
        }

        $newBook = new Book();
        $newBook->book_id = $book["id"];
        $newBook->title = $book["title"];
        $newBook->rating = $book["rating"] ?: 0;
        $newBook->pageCount = $book["pageCount"] ?: 0;
        $newBook->image = $book["image"] ?: '';
        $newBook->owner_id = Auth::user()->id;
        $newBook->order = Book::where('owner_id', Auth::user()->id)->count();
        $newBook->save();

        return response()->json($newBook, 200);
    }

    public function index(): JsonResponse
    {
        $allBooks = Book::select('book_id', 'image', 'pageCount', 'rating', 'title', 'order')->where('owner_id', Auth::user()->id)->get();

        return response()->json($allBooks);
    }

    /**
     * @param string $book
     */
    public function remove(string $book): Response
    {
        Book::where('owner_id', Auth::user()->id)->where('book_id', $book)->delete();

        $allBooks = Book::where('owner_id', Auth::user()->id)->orderBy('order', 'asc')->get();

        $order = 0;
        DB::beginTransaction();
        foreach ($allBooks as &$book)
        {
            $book->order = $order++;
            $book->save();
        }
        DB::commit();

        return response('', 204);
    }

    /**
     * @param Request $request
     */
    public function reorder(Request $request): Response
    {
        $booksToChange = $request->all();

        DB::beginTransaction();
        foreach ($booksToChange as $book)
        {
            /**
             * @var Book $dbbook
             */
            $dbbook = Book::where('owner_id', Auth::user()->id)->where('book_id', $book["book_id"])->first();
            if (!$dbbook)
            {
                DB::rollBack();

                return response('', 422);
            }
            $dbbook->order = $book["order"];
            $dbbook->save();
        }
        DB::commit();

        return response('', 204);
    }
}
