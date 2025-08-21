<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;

class CheckCertificateController extends Controller
{
    public function check($code){
        $check = Exam::where('certificated_name',"$code.pdf")->first();
      if($check){
          $status = 'success';
          $name = $check->user->name;
         return view('pages.verification',compact('name','code','status'));
      }else{
        $status = 'error';
        return view('pages.verification',compact('status'));
      }
    }
}
