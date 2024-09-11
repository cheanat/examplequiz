<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{


    public function sendSuccess($data,$message='',$status=401){
            $res = [
               'message' =>$message,
               'status' =>$status,
               'data'=> $data

            ];
            return response()->json($res);
    }
    public function sendError($error,$data=[],$status=400){
        $res = [
           'error'=> $error,
           'data' =>$data,
           'status' =>$status
        ];
        return response()->json($res);
}
}
