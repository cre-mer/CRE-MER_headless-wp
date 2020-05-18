<?php
namespace App\Http\Controllers;

class DevClearCacheController extends Controller
{
    public function clear_cache()
    {
        \Artisan::call('cache:clear');
        return redirect()->back()->with('status','Application cache cleared!');
    }

    public function clear_views()
    {
       \Artisan::call('view:clear');
       return redirect()->back()->with('status','Compiled views cleared!');
    }
}
