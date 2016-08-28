<?php

/**
 * Directors model config
 */

return [

    'title' => 'Theaters',

    'single' => 'Theater',

    'model' => '\App\Models\Theater',

    /**
     * The display columns
     */
    'columns' => [
        'id',
        'name' => [
            'title' => 'Name',
        ],
        'num_films' => [
            'title'        => '# films',
            'relationship' => 'films',
            'select'       => 'COUNT((:table).id)',
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
        'films' => [
            'title'      => 'Films',
            'type'       => 'relationship',
            'name_field' => 'name',
        ],
    ],

    /**
     * The editable fields
     */
    'edit_fields' => [
        'name' => [
            'title' => 'Name',
            'type'  => 'text',
        ],
        'films' => [
            'title'      => 'Films',
            'type'       => 'relationship',
            'name_field' => 'name',
        ],
    ],

];
