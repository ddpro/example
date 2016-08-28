<?php

/**
 * Actors model config
 */

return [

    'title' => 'Actors',

    'single' => 'actor',

    'model' => '\App\Models\Actor',

    /**
     * The display columns
     */
    'columns' => [
        'id',
        'full_name' => [
            'title'  => 'Name',
            'select' => "CONCAT((:table).first_name, ' ', (:table).last_name)",
        ],
        'num_films' => [
            'title'        => '# films',
            'relationship' => 'films',
            'select'       => 'COUNT((:table).id)',
        ],
        'formatted_birth_date' => [
            'title'      => 'Birth Date',
            'sort_field' => 'birth_date',
        ],
    ],

    /**
     * The filter set
     */
    'filters' => [
        'id',
        'first_name' => [
            'title' => 'First Name',
        ],
        'last_name' => [
            'title' => 'Last Name',
        ],
        'films' => [
            'title'      => 'Films',
            'type'       => 'relationship',
            'name_field' => 'name',
        ],
        'birth_date' => [
            'title' => 'Birth Date',
            'type'  => 'date'
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
        'birth_date' => [
            'title' => 'Birth Date',
            'type'  => 'date',
        ],
        'films' => [
            'title'      => 'Films',
            'type'       => 'relationship',
            'name_field' => 'name',
        ],
    ],

];
