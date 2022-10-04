<?php

namespace App\Http\Controllers;

use App\Models\CheckInCheckOut;
use App\Models\User;
use Illuminate\Http\Request;

class CheckInCheckOutController extends Controller
{
    public function index()
    {
        $hash_value = bcrypt(date('Y-m-d'));
        return view('checkin_checkout.index', compact('hash_value'));
    }

    public function checkPincode(Request $request)
    {
        $user = User::firstWhere('pin_code', $request->value);
        if (! $user) {
            return [
                'status'=>'fail',
                'message'=>"There insn't any user with this pincode.",
            ];
        }
        if (now()->format('D') == 'Sat' || now()->format('D') == 'Sun') {
            return [
                'status'=>'fail',
                'message'=>"Today is off day",
        ];
        }
        $checkin_checkout_data = CheckInCheckOut::firstOrCreate(
            [
                'user_id' => $user->id,
                'date'=>now()->format('Y-m-d')
            ],
        );
        if (! is_null($checkin_checkout_data->checkin_time) && ! is_null($checkin_checkout_data->checkout_time)) {
            return [
                'status'=>'fail',
                'message'=>"You are already checkin and checkout.",
        ];
        }
        if (is_null($checkin_checkout_data->checkin_time)) {
            $checkin_checkout_data->checkin_time = now();
            $message = 'Your are successfully check in at' . now();
        } else {
            if (is_null($checkin_checkout_data->checkout_time)) {
                $checkin_checkout_data->checkout_time = now();
                $message = 'Your are successfully checkout at' . now();
            }
        }
        $checkin_checkout_data->update();

        return [
            'status'=>'success',
            'message'=>$message
        ];
    }
}
