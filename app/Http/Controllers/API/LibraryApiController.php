<?php

namespace App\Http\Controllers\API;


use App\Models\User;
use App\Models\Book;
use App\Models\Library;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LibraryStoreRequest;
use App\Http\Requests\LibraryUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Services\LibraryServices;

class LibraryApiController extends Controller
{
    /**
     * Getting Reading List and update
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeList(Request $request){

        // Separating Logic to Service Class
        $saved = (new LibraryServices())->updateReadingList($request->data, $request->user_id);

        if($saved){
            return response( [ 'message' => 'Reading List Updated'] , Response::HTTP_OK);
        }

        return response( [ 'error' => 'Reading List not Updated'] , Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function fetchUserLibraryList($user_id){
        // Separating Logic to Service Class
        return (new LibraryServices())->getUserReadingList($user_id);
    }


    /**
     * Getting all Books
     */
    public function getBooks()
    {
        return '{"error":"0","total":"20","books":[{"title":"Learn Programming","subtitle":"Your Guided Tour Through the Programming Jungle","isbn13":"9781722834920","price":"$16.83","image":"https://itbook.store/img/books/9781722834920.png","url":"https://itbook.store/books/9781722834920"},{"title":"Graph Databases For Beginners","subtitle":"The #1 Platform for Connected Data","isbn13":"1001606307637","price":"$0.00","image":"https://itbook.store/img/books/1001606307637.png","url":"https://itbook.store/books/1001606307637"},{"title":"Elementary Algorithms","subtitle":"","isbn13":"1001606307729","price":"$0.00","image":"https://itbook.store/img/books/1001606307729.png","url":"https://itbook.store/books/1001606307729"},{"title":"Windows PowerShell Networking Guide","subtitle":"","isbn13":"1001606307964","price":"$0.00","image":"https://itbook.store/img/books/1001606307964.png","url":"https://itbook.store/books/1001606307964"},{"title":"Operating Systems: From 0 to 1","subtitle":"","isbn13":"1001606140658","price":"$0.00","image":"https://itbook.store/img/books/1001606140658.png","url":"https://itbook.store/books/1001606140658"},{"title":"Java Web Scraping Handbook","subtitle":"Learn advanced Web Scraping techniques","isbn13":"1001606140805","price":"$0.00","image":"https://itbook.store/img/books/1001606140805.png","url":"https://itbook.store/books/1001606140805"},{"title":"Coffee Break Python Slicing","subtitle":"24 Workouts to Master Slicing in Python, Once and for All","isbn13":"1001605784161","price":"$0.00","image":"https://itbook.store/img/books/1001605784161.png","url":"https://itbook.store/books/1001605784161"},{"title":"The Basics of User Experience Design","subtitle":"","isbn13":"1001601301730","price":"$0.00","image":"https://itbook.store/img/books/1001601301730.png","url":"https://itbook.store/books/1001601301730"},{"title":"3D Game Development with LWJGL 3","subtitle":"Learn the main concepts involved in writing 3D games using the Lighweight Java Gaming Library","isbn13":"1001601302020","price":"$0.00","image":"https://itbook.store/img/books/1001601302020.png","url":"https://itbook.store/books/1001601302020"},{"title":"DevOps: WTF?","subtitle":"","isbn13":"1001592565453","price":"$0.00","image":"https://itbook.store/img/books/1001592565453.png","url":"https://itbook.store/books/1001592565453"},{"title":"Full Speed Python","subtitle":"","isbn13":"1001592395975","price":"$0.00","image":"https://itbook.store/img/books/1001592395975.png","url":"https://itbook.store/books/1001592395975"},{"title":"How To Code in Python 3","subtitle":"","isbn13":"9780999773017","price":"$0.00","image":"https://itbook.store/img/books/9780999773017.png","url":"https://itbook.store/books/9780999773017"},{"title":"Operating System Concepts, 10th Edition","subtitle":"","isbn13":"9781119456339","price":"$90.08","image":"https://itbook.store/img/books/9781119456339.png","url":"https://itbook.store/books/9781119456339"},{"title":"Neural Networks and Deep Learning","subtitle":"A Textbook","isbn13":"9783319944623","price":"$33.99","image":"https://itbook.store/img/books/9783319944623.png","url":"https://itbook.store/books/9783319944623"},{"title":"Fundamentals of C++ Programming","subtitle":"","isbn13":"1001590483252","price":"$0.00","image":"https://itbook.store/img/books/1001590483252.png","url":"https://itbook.store/books/1001590483252"},{"title":"Fundamentals of Python Programming","subtitle":"","isbn13":"1001590485785","price":"$0.00","image":"https://itbook.store/img/books/1001590485785.png","url":"https://itbook.store/books/1001590485785"},{"title":"Machine Learning Yearning","subtitle":"Technical Strategy for AI Engineers, In the Era of Deep Learning","isbn13":"1001590486081","price":"$0.00","image":"https://itbook.store/img/books/1001590486081.png","url":"https://itbook.store/books/1001590486081"},{"title":"React in patterns","subtitle":"","isbn13":"1001590486262","price":"$0.00","image":"https://itbook.store/img/books/1001590486262.png","url":"https://itbook.store/books/1001590486262"},{"title":"AI Blueprints","subtitle":"How to build and deploy AI business projects","isbn13":"9781788992879","price":"$31.99","image":"https://itbook.store/img/books/9781788992879.png","url":"https://itbook.store/books/9781788992879"},{"title":"Data Analysis with Python","subtitle":"A Modern Approach","isbn13":"9781789950069","price":"$31.99","image":"https://itbook.store/img/books/9781789950069.png","url":"https://itbook.store/books/9781789950069"}]}';
    }
}
