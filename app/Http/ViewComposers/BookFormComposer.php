<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class BookFormComposer
{
    /**
     * Create a new book form composer.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $with = array_merge([
            'title' => '',
            'author' => '',
            'publication_date' => '',
            'isbn13' => ''
        ], $view->getData());
        
        $view->with($with);
    }
}
