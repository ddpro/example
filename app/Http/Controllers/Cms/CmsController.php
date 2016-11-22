<?php
/**
 * Class CmsController
 */

namespace App\Http\Controllers\Cms;

use Delatbabel\ViewPages\Http\Controllers\VpageController;
use Illuminate\Http\Request;

/**
 * Class CmsController
 *
 * Handles requests for any application dynamic page.
 */
class CmsController extends VpageController
{
    public function make(Request $request)
    {
        return parent::make($request);
    }
}
