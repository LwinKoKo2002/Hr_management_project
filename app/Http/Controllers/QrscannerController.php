<?php

namespace App\Http\Controllers;

use App\Models\CheckInCheckOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class QrscannerController extends Controller
{
    public function qrScanner()
    {
        return view('qrScanner');
    }

    public function checkScanner(Request $request)
    {
        if (!Hash::check(date('Y-m-d'), $request->value)) {
            return back()->withErrors(['fail'=>'Invalid QR code'])->withInput();
        }
        if (now()->format('D') == 'Sat' || now()->format('D') == 'Sun') {
            return [
                'status'=>'fail',
                'message'=>"Today is off day",
        ];
        }
        $user = auth()->user();
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
