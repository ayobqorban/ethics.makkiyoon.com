<?php
namespace App\Http\Controllers;


class ExamController extends Controller
{
    public function show($id){
        return view('pages.exams.exam',['form_id'=>$id]);
    }
}
