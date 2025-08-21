<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GfOptionsController extends Controller
{
    public function index($id){
        return view('pages.gf-forms.options',compact('id'));
    }
}
