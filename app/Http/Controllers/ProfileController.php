<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $employee = auth()->user();
        $roles = $employee->roles;
        return view('profile.index', compact('employee', 'roles'));
    }
}
