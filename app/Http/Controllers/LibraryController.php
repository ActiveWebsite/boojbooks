<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\Library;
use Illuminate\Http\Request;
use App\Http\Requests\LibraryStoreRequest;
use App\Http\Requests\LibraryUpdateRequest;
use Illuminate\Support\Facades\Auth;

class LibraryController extends Controller
{

    /***
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function home(Request $request)
    {
        $user_id = Auth::id();
        return view('home', compact('user_id'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $search = $request->get('search', '');

        $libraries = Library::search($search)
            ->latest()
            ->paginate(5);

        return view('app.libraries.index', compact('libraries', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $users = User::pluck('name', 'id');
        $books = Book::pluck('title', 'id');

        return view('app.libraries.create', compact('users', 'books'));
    }

    /**
     * @param \App\Http\Requests\LibraryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(LibraryStoreRequest $request)
    {

        $validated = $request->validated();

        $library = Library::create($validated);

        return redirect()
            ->route('libraries.edit', $library)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Library $library
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Library $library)
    {

        return view('app.libraries.show', compact('library'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Library $library
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Library $library)
    {

        $users = User::pluck('name', 'id');
        $books = Book::pluck('title', 'id');

        return view('app.libraries.edit', compact('library', 'users', 'books'));
    }

    /**
     * @param \App\Http\Requests\LibraryUpdateRequest $request
     * @param \App\Models\Library $library
     * @return \Illuminate\Http\Response
     */
    public function update(LibraryUpdateRequest $request, Library $library)
    {

        $validated = $request->validated();

        $library->update($validated);

        return redirect()
            ->route('libraries.edit', $library)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Library $library
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Library $library)
    {

        $library->delete();

        return redirect()
            ->route('libraries.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
