<?php

namespace App\Http\Controllers\User\Analytics;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
      return view('content.dashboard.user');
    }

}
