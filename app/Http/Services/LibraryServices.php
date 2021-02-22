<?php


namespace App\Http\Services;
use App\Models\User;
use App\Models\Book;
use App\Models\Library;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LibraryStoreRequest;
use App\Http\Requests\LibraryUpdateRequest;

class LibraryServices
{

    /**
     *  Logic of update library Reading List
     * @param $data
     * @param $user_id
     */
    public function updateReadingList($data, $user_id) {

        // array for storing updated ids
        $updated_ids = [];

        $order_id = 1;
        foreach ($data as $element) {

            // Saving Book in local DB
            $book = Book::firstOrNew(['isbn13'  => $element['isbn13']]);

            $book->title    = $element['title'];
            $book->subtitle = $element['subtitle'];
            $book->isbn13   = $element['isbn13'];
            $book->price    = $element['price'];
            $book->image    = $element['image'];
            $book->url      = $element['url'];
            $book->save();


            // updateOrCreate a new record in Reading List - Library Model
            $record = [
                'user_id' => $user_id,
                'book_id' => $book->id,
            ];
            $order = [
                'order'   => $order_id,
            ];
            $library = Library::updateOrCreate($record, $order);
            $order_id++;

            // store ids of updated model
            $updated_ids[] = $library->id;
        }

        // delete models not updated
        Library::where('user_id', $user_id)->whereNotIn('id',$updated_ids)->delete();

        return true;
    }


    public function getUserReadingList($user_id){
        $library = Library::where('user_id', $user_id)->get();
        //dd($library);
        $items = array();
        foreach ($library as $element) {
            $book = Book::where('id',$element->book_id)->first();
            array_push($items,
                [
                "title" => $book->title,
                "subtitle" => $book->subtitle,
                "isbn13" =>  $book->isbn13,
                "price" =>  $book->price,
                "image" =>  $book->image,
                "url" =>  $book->url,
                "order" =>  $element->order,
            ]);
        }

        return $items;


    }

}
