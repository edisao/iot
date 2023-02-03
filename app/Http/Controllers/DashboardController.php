<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        //$pass = password_hash("@UNL-Cloud*2022", PASSWORD_DEFAULT);
        //Log::critical("Pass: " . $pass);

        return view('core.dashboard.index');
    }
}
