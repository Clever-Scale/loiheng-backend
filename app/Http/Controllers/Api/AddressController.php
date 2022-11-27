<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AddressCollection;

class AddressController extends BaseController
{
    public function getByUserIdAddress($id)
    {
        try{
            $address = new AddressCollection(Address::where('user_id', $id)->paginate(10));
            return $this->sendResponse($address,"Shipping address data getting successfully!");

        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }

    }
    public function createAddress(Request $request)
    {
        try{
            $address = Address::create([
                'user_id' => $request->user_id,
                'full_name' => $request->full_name,
                'phone' => $request->phone,
                'city' => $request->city,
                'township' => $request->township,
                'region' => $request->region,
                'address_type' => $request->address_type,
                'street_address' => $request->street_address,
            ]);
            return $this->sendResponse($address,"Address added successfully!.");
        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

    public function removeAddress($id)
    {
        try{
           $address=  Address::findOrFail($id)->update([
            'is_active' => false
           ]);
            return $this->sendMessageResponse("Address added successfully!.");
        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }
}
