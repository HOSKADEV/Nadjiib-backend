<?php

namespace App\Http\Controllers\Dashboard\Analytics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnalyticicsController extends Controller
{
    public function index()
    {
      return view('content.dashboard.dashboards-analytics');
    }
}
