<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCompanySetting;
use App\Models\CompanySetting;
use App\Models\User;
use Illuminate\Http\Request;

class CompanySettingController extends Controller
{
    public function index()
    {
        $user = User::firstWhere('id', auth()->id());
        if (! $user->can('view_company_setting')) {
            abort('403', 'This action is unauthorized');
        }
        $settings = CompanySetting::all();
        return view('company.index', compact('settings'));
    }


    public function edit(CompanySetting $company_setting)
    {
        $user = User::firstWhere('id', auth()->id());
        if (! $user->can('edit_company_setting')) {
            abort('403', 'This action is unauthorized');
        }
        return view('company.edit', compact('company_setting'));
    }


    public function update(UpdateCompanySetting $request, CompanySetting $company_setting)
    {
        $validated = $request->validated();
        $company_setting->update($validated);
        return redirect()->route('company-setting.index')->with(['update'=>'Company Setting is successfully updated.']);
    }
}
