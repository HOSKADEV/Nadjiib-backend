<?php

namespace App\Http\Controllers\Dashboard\Analytics;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Charts\Users\DailyUsersChart;
use App\Charts\Users\UserStatusChart;
use App\Charts\Users\YearlyUsersChart;
use App\Charts\Users\MonthlyUsersChart;
use App\Charts\Courses\CourseStatusChart;
use App\Charts\Purchases\DailyPurchasesChart;
use App\Charts\Purchases\PurchaseStatusChart;
use App\Charts\Purchases\YearlyPurchasesChart;
use App\Charts\Purchases\MonthlyPurchasesChart;
use App\Charts\Purchases\PurchasesDetailsChart;
use App\Charts\CloudCommunity\DailyCloudCommunityChart;
use App\Charts\CloudCommunity\YearlyCloudCommunityChart;
use App\Charts\CloudCommunity\MonthlyCloudCommunityChart;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
      //dd($request->all());
      //return view('content.dashboard.dashboards-analytics');
      return view('content.dashboard.placeholder');

    }

    public function stats(Request $request)
    {

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

      $cloud_community_chart = match($request->cloud_community_chart){
        'monthly' => new MonthlyCloudCommunityChart(),
        'yearly' => new YearlyCloudCommunityChart(),
        default => new DailyCloudCommunityChart()
      };

      $users_status_chart = new UserStatusChart();
      $courses_status_chart = new CourseStatusChart();
      $purchases_status_chart = new PurchaseStatusChart();

      $purchases_details_chart = new PurchasesDetailsChart($request->year ?? now()->year);

      return view('content.dashboard.stats', [
      'users_chart' => $users_chart->build(),
      'purchases_chart' => $purchases_chart->build(),
      'cloud_community_chart' => $cloud_community_chart->build(),
      'users_status_chart' => $users_status_chart->build(),
      'courses_status_chart' => $courses_status_chart->build(),
      'purchases_status_chart' => $purchases_status_chart->build(),
      'purchases_details_chart' => $purchases_details_chart->build()
    ]);
    }

}
