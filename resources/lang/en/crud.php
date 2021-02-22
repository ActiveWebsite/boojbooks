<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Users List',
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'show_title' => 'Show User',
        'inputs' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ],
    ],

    'books' => [
        'name' => 'Books',
        'index_title' => 'Books List',
        'create_title' => 'Create Book',
        'edit_title' => 'Edit Book',
        'show_title' => 'Show Book',
        'inputs' => [
            'title' => 'Title',
            'subtitle' => 'Subtitle',
            'isbn13' => 'Isbn13',
            'price' => 'Price',
            'image' => 'Image',
            'url' => 'Url',
        ],
    ],

    'libraries' => [
        'name' => 'Libraries',
        'index_title' => 'Users Library List',
        'create_title' => 'Create Library',
        'edit_title' => 'Edit Library',
        'show_title' => 'Show Library',
        'inputs' => [
            'user_id' => 'User',
            'book_id' => 'Book',
            'order' => 'Order',
        ],
    ],

    'roles' => [
        'name' => 'Roles',
        'index_title' => 'Roles List',
        'create_title' => 'Create Role',
        'edit_title' => 'Edit Role',
        'show_title' => 'Show Role',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'permissions' => [
        'name' => 'Permissions',
        'index_title' => 'Permissions List',
        'create_title' => 'Create Permission',
        'edit_title' => 'Edit Permission',
        'show_title' => 'Show Permission',
        'inputs' => [
            'name' => 'Name',
        ],
    ],
];
