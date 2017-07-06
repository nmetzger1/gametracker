<?php

namespace App\Http\Controllers;

use App\mysql;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $playData = mysql::GetAllPlays();

        return view('home', ['playData' => $playData]);
    }
}
