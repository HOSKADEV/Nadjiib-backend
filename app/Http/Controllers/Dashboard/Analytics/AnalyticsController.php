<?php

namespace App\Http\Controllers\Dashboard\Analytics;

use Illuminate\Http\Request;
use App\Charts\DailyUsersChart;
use App\Charts\UserStatusChart;
use App\Charts\YearlyUsersChart;
use App\Charts\CourseStatusChart;
use App\Charts\MonthlyUsersChart;
use App\Charts\DailyPurchasesChart;
use App\Charts\PurchaseStatusChart;
use App\Charts\YearlyPurchasesChart;
use App\Http\Controllers\Controller;
use App\Charts\MonthlyPurchasesChart;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
      //dd($request->all());
      //return view('content.dashboard.dashboards-analytics');
      //return view('content.dashboard.placeholder');

      $users_chart = match($request->users_chart){
        'monthly' => new MonthlyUsersChart(),
        'yearly' => new YearlyUsersChart(),
        default => new DailyUsersChart()
      };

      $purchases_chart = match($request->purchases_chart){
        'monthly' => new MonthlyPurchasesChart(),
        'yearly' => new YearlyPurchasesChart(),
        default => new DailyPurchasesChart()
      };

      $users_status_chart = new UserStatusChart();
      $courses_status_chart = new CourseStatusChart();
      $purchases_status_chart = new PurchaseStatusChart();

      return view('content.dashboard.stats', [
      'users_chart' => $users_chart->build(),
      'purchases_chart' => $purchases_chart->build(),
      'users_status_chart' => $users_status_chart->build(),
      'courses_status_chart' => $courses_status_chart->build(),
      'purchases_status_chart' => $purchases_status_chart->build()
    ]);
    }

}
