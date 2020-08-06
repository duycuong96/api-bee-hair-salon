<?php

namespace App\Http\Controllers\Client\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\Client\ContactMail;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function sendContact(Request $request)
    {
        $data = $request->all();
        $validate = Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ], [
            'required' => ':attribute không được để trống',
            'email' => ':attribute không đúng định dạng email',
        ], [
            'email' => 'Email',
            'name' => 'Tên',
            'message' => 'Lời nhắn'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validate->errors()
            ], 422);
        }
        $email = $request->email;
        $contact = Contact::create($data);
        Mail::to($email)->send(new ContactMail);
    }

}
