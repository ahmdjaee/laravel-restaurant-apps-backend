<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Utils\Trait\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    use ApiResponse;
    public function send(Request $request)
    {
        //    dd($request->all());


        // $data = $request->validate([
        //     'name' => ['required', 'max:100'],
        //     'email' => ['required', 'email'],
        //     'message' => ['required', 'max:1000'],
        // ]);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:100'],
            'email' => ['required', 'email'],
            'subject' => ['required', 'max:100'],
            'message' => ['required', 'max:1000'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $data = $validator->validate();

        Mail::to(config('mail.from.address'))->send(new ContactMail($data));

        return $this->apiResponse($request->all(), 'Contact send successfully', 200);
    }
}
