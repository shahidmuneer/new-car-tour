<?php

namespace App\Http\Controllers\Frontend;
use App\Models\Package;
/**
 * Class HomeController.
 */
class HomeController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
       
        return view("index");
        // return view('frontend.index');
    }
}
