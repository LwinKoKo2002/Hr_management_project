<?php

namespace App\Http\Controllers;

use App\Models\CheckInCheckOut;
use App\Models\CompanySetting;
use App\Models\Month;
use Carbon\Carbon;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class SalaryOverviewController extends Controller
{
    public function salaryOverview()
    {
        $months = Month::all();
        return view('salary.overview', compact('months'));
    }

    public function overviewTable(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        $employees = User::where('name', 'LIKE', '%'.$request->employee.'%')->get();
        $startMonth = $year.'-'.$month.'-'.'01';
        $endMonth = Carbon::parse($startMonth)->endOfMonth();
        $dayInMonths =  Carbon::parse($startMonth)->daysInMonth;
        $workingDays =Carbon::parse($startMonth)->diffInDaysFiltered(function (Carbon $date) {
            return $date->isWeekday();
        }, Carbon::parse($endMonth));
        $offDays = $dayInMonths - $workingDays;
        $periods = new CarbonPeriod($startMonth, $endMonth);
        $setting = CompanySetting::findOrFail(1);
        $attendances = CheckInCheckOut::whereMonth('date', $month)->whereYear('date', $year)->get();
        return view('components.salary_overview_table', compact('month', 'year', 'employees', 'dayInMonths', 'workingDays', 'offDays', 'periods', 'setting', 'attendances'))->render();
    }
    public function myOverviewTable(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        $employees = User::where('id', auth()->id())->get();
        $startMonth = $year.'-'.$month.'-'.'01';
        $endMonth = Carbon::parse($startMonth)->endOfMonth();
        $dayInMonths =  Carbon::parse($startMonth)->daysInMonth;
        $workingDays =Carbon::parse($startMonth)->diffInDaysFiltered(function (Carbon $date) {
            return $date->isWeekday();
        }, Carbon::parse($endMonth));
        $offDays = $dayInMonths - $workingDays;
        $periods = new CarbonPeriod($startMonth, $endMonth);
        $setting = CompanySetting::findOrFail(1);
        $attendances = CheckInCheckOut::whereMonth('date', $month)->whereYear('date', $year)->get();
        return view('components.salary_overview_table', compact('month', 'year', 'employees', 'dayInMonths', 'workingDays', 'offDays', 'periods', 'setting', 'attendances'))->render();
    }
}
