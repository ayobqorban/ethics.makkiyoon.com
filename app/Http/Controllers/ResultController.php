<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResultController extends Controller
{

    public function index(){
        return view('pages.results.index');
    }
    public function show($id){
        return view('pages.results.show');
    }

    public function result_show($id){
        return view('pages.results.resultShow',compact('id'));
    }
}
