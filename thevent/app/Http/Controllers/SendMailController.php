<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

class SendMailController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function send(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|string|email'
        ]);

        $message = Hash::make($request['email']);
        $data = array(
            'name' => $request['name'],
            'message' => $message
        );

        Mail::to($request['email'])->send(new SendMail($data));

        return response(['Successfully sent!'], 200);
    }
}
