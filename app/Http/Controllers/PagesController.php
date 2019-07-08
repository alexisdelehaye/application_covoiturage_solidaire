<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    public function index() {
    	$stops = DB::table('stops')
            ->select('*')
            ->orderBy('zip', 'ASC')
            ->get();

    	return view('pages.index')->with('stops', $stops);
    }
}
