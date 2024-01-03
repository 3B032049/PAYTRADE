<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
const SUPER_ADMIN_ROLE = 'super-admin';
const HIGH_LEVEL_ADMIN_ROLE = 'high-level-admin';
const GENERAL_ADMIN_ROLE = 'general-admin';

class AdminSettingsController extends Controller
{
    public function index()
    {
        return view('admins.settings.index');
    }
}
