<?php

namespace App\Http\Controllers;

use App\Subscribe;
use GuzzleHttp\Promise\Promise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class SubscribeController extends Controller
{
    public function store(Request $request){
        $subscription = new Subscribe();
        $subscription->email = $request->input('email');

        $rules = [
            'email' => 'required|email|unique:subscribes,email'
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], Response::HTTP_BAD_REQUEST);
//            return response()->json(["errors" => $validator->errors()], Promise::REJECTED);
        }

        $subscription->save();
        return response()->json($subscription, Response::HTTP_CREATED);
    }
}
