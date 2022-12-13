<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AddressCollection;

class AddressController extends BaseController
{
    public function getByUserIdAddress()
    {
        try{
            $user = auth('sanctum')->user();
            $address = new AddressCollection(Address::where('user_id', $user->id)->paginate(10));
            return $this->sendResponse($address,"Shipping address data getting successfully!");

        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }

    }
    public function createAddress(Request $request)
    {
        try{
            $user = auth('sanctum')->user();
            $address = Address::create([
                'user_id' => $user->id,
                'full_name' => $request->full_name,
                'phone' => $request->phone,
                'city' => $request->city,
                'township' => $request->township,
                'region' => $request->region,
                'address_type' => $request->address_type,
                'street_address' => $request->street_address,
                'is_default' => $request->is_default,
            ]);
            return $this->sendResponse($address,"Address added successfully!.");
        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

    public function removeAddress($id)
    {
        try{
            $user = auth('sanctum')->user();
            $old = Address::where('user_id', $user->id)->where('id', $id)->value('id');
            if($old != null){
                 Address::findOrFail($id)->update([
                    'is_active' => false
                   ]);
                    return $this->sendMessageResponse("Address removed successfully!.");
            }else{
                return $this->sendErrorMessageResponse('something went wrong!');
            }
        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

    public function defaultAddress($id)
    {
        try{
            $user = auth('sanctum')->user();
            $old = Address::where('user_id', $user->id)->where('id', $id)->value('id');
            if($old != null){
                Address::findOrFail($id)->update([
                    'is_default' => true
                ]);

                $address = Address::find($id);

                Address::where('id', '!=', $address->id)->where('user_id', $address->user_id)->update([
                    'is_default' => false
                ]);
                return $this->sendMessageResponse("Address defaulted successfully!.");
            }else{
                return $this->sendErrorMessageResponse('something went wrong!');
            }
        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }
}
