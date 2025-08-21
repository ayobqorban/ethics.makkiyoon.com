<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GfQuestionsController extends Controller
{
    public function index(){
        return view('pages.gf-forms.question');
    }
}
