<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ArticleController extends Controller
{
    public function index()
    {
    	$list = DB::table('article')->get();
    	return $list;
    }

    public function show(Request $request)
    {
    	$id = $request->id;
    }
}
