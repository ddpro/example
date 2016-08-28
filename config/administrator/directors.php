<?php

/**
 * Directors model config
 */

return [

    'title' => 'Directors',

    'single' => 'director',

    'model' => '\App\Models\Director',

    /**
     * The display columns
     */
    'columns' => [
        'name' => [
            'title' => 'Name',
        ],
        'formatted_salary' => [
            'title'      => 'Salary',
            'sort_field' => 'salary'
        ],
        'num_films' => [
            'title'    => '# films',
            'relation' => 'films',
            'select'   => 'COUNT((:table).id)',
        ],
        'created_at',
    ],

    /**
     * The filter set
     */
    'filters' => [
        'id',
        'first_name',
        'last_name',
        'salary' => [
            'type'     => 'number',
            'symbol'   => '$',
            'decimals' => 2,
        ],
        'created_at' => [
            'type' => 'datetime'
        ],
    ],

    /**
     * The editable fields
     */
    'edit_fields' => [
        'first_name' => [
            'title' => 'First Name',
            'type'  => 'text',
        ],
        'last_name' => [
            'title' => 'Last Name',
            'type'  => 'text',
        ],
        'salary' => [
            'title'    => 'Salary',
            'type'     => 'number',
            'symbol'   => '$',
            'decimals' => 2
        ],
    ],

];
