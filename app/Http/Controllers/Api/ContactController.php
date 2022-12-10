<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends BaseController
{
    public function contact(Request $request)
    {

        try{
            $contact = Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_no' => $request->phone_no,
                'subject' => $request->subject,
                'description' => $request->description,
            ]);
            return $this->sendResponse($contact,"Contact send successfully!.");
        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }
}
