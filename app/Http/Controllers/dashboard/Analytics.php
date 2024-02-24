<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class Analytics extends Controller
{
  public function index()
  {
    //dd(Auth::id());
    return view('content.dashboard.dashboards-analytics');
  }
}
