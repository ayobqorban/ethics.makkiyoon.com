<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function check($code){
        $check = Certificate::where('certificate_id',$code)->first();
        return view('backend.verification.index',compact(['code','check']));
    }
}
