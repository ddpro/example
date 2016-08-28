<?php

/**
 * The main site settings page
 */

return [

    /**
     * Settings page title
     *
     * @type string
     */
    'title' => 'Site Settings',

    /**
     * The edit fields array
     *
     * @type array
     */
    'edit_fields' => [
        'site_name' => [
            'title' => 'Site Name',
            'type'  => 'text',
            'limit' => 50,
        ],
        'page_cache_lifetime' => [
            'title' => 'Page Cache Lifetime (in minutes)',
            'type'  => 'number',
        ],
        'logo' => [
            'title'      => 'Image (200 x 150)',
            'type'       => 'image',
            'naming'     => 'random',
            'location'   => public_path(),
            'size_limit' => 2,
            'sizes'      => [
                [200, 150, 'crop', public_path() . '/resize/', 100],
            ]
        ],
    ],

    /**
     * The validation rules for the form, based on the Laravel validation class
     *
     * @type array
     */
    'rules' => [
        'site_name'           => 'required|max:50',
        'page_cache_lifetime' => 'required|integer',
        'logo'                => 'required',
    ],

    /**
     * This is run prior to saving the JSON form data
     *
     * @type Callable
     * @param array     $data
     *
     * @return string (on error) / void (otherwise)
     */
    'before_save' => function (&$data) {
        $data['site_name'] = $data['site_name'] . ' - The Blurst Site Ever';
    },

    /**
     * The permission option is an authentication check that lets you define a closure that should return true if the current user
     * is allowed to view this settings page. Any "falsey" response will result in a 404.
     *
     * @type closure
     */
    'permission' => function () {
        return true;
        //return Auth::user()->hasRole('developer');
    },

    /**
     * This is where you can define the settings page's custom actions
     */
    'actions' => [
        //Ordering an item up
        'clear_page_cache' => [
            'title'    => 'Clear Page Cache',
            'messages' => [
                'active'  => 'Clearing cache...',
                'success' => 'Page Cache Cleared',
                'error'   => 'There was an error while clearing the page cache',
            ],
            //the settings data is passed to the closure and saved if a truthy response is returned
            'action' => function (&$data) {
                Cache::forget('pages');

                return true;
            }
        ],
    ],
];
