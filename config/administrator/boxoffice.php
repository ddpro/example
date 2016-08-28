<?php

/**
 * Box Office model config
 */

return [

    'title' => 'Box Office',

    'single' => 'take',

    'model' => '\App\Models\BoxOffice',

    /**
     * The display columns
     */
    'columns' => [
        'id',
        'formatted_revenue' => [
            'title'      => 'Revenue',
            'sort_field' => 'revenue',
        ],
        'film' => [
            'title'        => 'Film',
            'relationship' => 'film',
            'select'       => '(:table).name',
        ],
        'theater' => [
            'title'        => 'Theater',
            'relationship' => 'theater',
            'select'       => '(:table).name',
        ],
    ],

    /**
     * The filter set
     */
    'filters' => [
        'id',
        'revenue' => [
            'title'    => 'Revenue',
            'type'     => 'number',
            'symbol'   => '$',
            'decimals' => 2,
        ],
        'film' => [
            'title'      => 'Film',
            'type'       => 'relationship',
            'name_field' => 'name',
        ],
        'theater' => [
            'title'      => 'Theater',
            'type'       => 'relationship',
            'name_field' => 'name',
        ],
    ],

    /**
     * The editable fields
     */
    'edit_fields' => [
        'revenue' => [
            'title'    => 'Revenue',
            'type'     => 'number',
            'symbol'   => '$',
            'decimals' => 2,
        ],
        'film' => [
            'title'      => 'Film',
            'type'       => 'relationship',
            'name_field' => 'name',
        ],
        'theater' => [
            'title'      => 'Theater',
            'type'       => 'relationship',
            'name_field' => 'name',
        ],
    ],

];
