<?php
/**
 * CMS Routes
 */

// CMS START
Route::any('{slug}', [
    'as'    => 'vpage.make',
    'uses'  => 'Cms\CmsController@make'
])->where('slug', '.*')
  ->where('slug', '^(?!admin)(?!img)(?!api)(?!sysadmin)(?!password)([A-z\d-\/_.]+)?');
// CMS END
