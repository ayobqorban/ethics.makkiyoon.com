<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Form;
use Illuminate\Http\Request;

class GfFormController extends Controller
{
    public function index(){
        return view('pages.gf-forms.form');
    }

    public function show($id){
        return view('pages.gf-forms.show',compact('id'));
    }
    public function insert_form($gfFormId,$examId){
        return view('pages.gf-forms.insert_form',compact('gfFormId','examId'));
    }

    public function result_form($id){
        return view('pages.gf-forms.result_form',compact('id'));
    }
}
