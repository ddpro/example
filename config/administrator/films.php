<?php

/**
 * Films model config
 */

return [

    'title' => 'Films',

    'single' => 'film',

    'model' => '\App\Models\Film',

    /**
     * The display columns
     */
    'columns' => [
        'id',
        'name',
        'release_date' => [
            'title' => 'release date'
        ],
        'director_name' => [
            'title'        => 'Director Name',
            'relationship' => 'director',
            'select'       => "CONCAT((:table).first_name, ' ', (:table).last_name)"
        ],
        'num_actors' => [
            'title'        => '# Actors',
            'relationship' => 'actors',
            'select'       => "COUNT((:table).id)"
        ],
        'box_office' => [
            'title'        => 'Box Office',
            'relationship' => 'boxOffice',
            'select'       => "CONCAT('$', FORMAT(SUM((:table).revenue), 2))"
        ],
    ],

    /**
     * The filter set
     */
    'filters' => [
        'id',
        'name',
        'release_date' => [
            'title'       => 'Release Date',
            'type'        => 'date',
            'date_format' => 'yy-mm-dd',
        ],
        'director' => [
            'title'              => 'Director',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'options_sort_field' => "CONCAT(first_name, ' ' , last_name)",
        ],
        'actors' => [
            'title'              => 'Actors',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'options_sort_field' => "CONCAT(first_name, ' ' , last_name)",
        ],
    ],

    /**
     * The editable fields
     */
    'edit_fields' => [
        'name',
        'release_date' => [
            'title'       => 'Release Date',
            'type'        => 'date',
            'date_format' => 'yy-mm-dd',
        ],
        'director' => [
            'title'              => 'Director',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'options_sort_field' => "CONCAT(first_name, ' ' , last_name)",
        ],
        'actors' => [
            'title'              => 'Actors',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'options_sort_field' => "CONCAT(first_name, ' ' , last_name)",
        ],
        'theaters' => [
            'title'      => 'Theater',
            'type'       => 'relationship',
            'name_field' => 'name',
        ],
    ],

];
