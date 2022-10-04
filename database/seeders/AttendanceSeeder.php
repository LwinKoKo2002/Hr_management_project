<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use App\Models\CheckInCheckOut;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        foreach ($users as $user) {
            $periods = new CarbonPeriod('2022-08-01', '2022-09-30');
            foreach ($periods as $period) {
                if ($period->format('D') != 'Sat' &&  $period->format('D') != 'Sun') {
                    $attendance = new CheckInCheckOut();
                    $attendance->user_id = $user->id;
                    $attendance->date = $period->format('Y-m-d');
                    $attendance->checkin_time = Carbon::parse($attendance->date . ' ' . '09:00:00')->addMinutes(rand(1, 55));
                    $attendance->checkout_time = Carbon::parse($attendance->date . ' ' . '18:00:00')->subMinutes(rand(1, 55));
                    $attendance->save();
                }
            }
        }
    }
}
