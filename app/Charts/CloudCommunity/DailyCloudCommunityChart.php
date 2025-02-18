<?php

namespace App\Charts\CloudCommunity;

use App\Models\Call;
use App\Models\Chat;
use App\Models\Post;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class DailyCloudCommunityChart
{
    protected $chart;

    public function __construct()
    {
        $this->chart = new LarapexChart();
    }

    public function build()
    {

      $posts_data = Post::whereDate('created_at', '>=' , Carbon::now()->subDays(6))
      ->groupBy(DB::raw('DATE(created_at)'))
      ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(id) AS posts'))
      ->get()->pluck( 'posts','date')->all();

      $chats_data = Chat::whereDate('created_at', '>=' , Carbon::now()->subDays(6))
      ->groupBy(DB::raw('DATE(created_at)'))
      ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(id) AS chats'))
      ->get()->pluck( 'chats','date')->all();

      $calls_data = Call::whereDate('created_at', '>=' , Carbon::now()->subDays(6))
      ->groupBy(DB::raw('DATE(created_at)'))
      ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(id) AS chats'))
      ->get()->pluck( 'chats','date')->all();

      $xaxis = [];
      $dates = [];
      $posts_yaxis = [];
      $chats_yaxis = [];
      $calls_yaxis = [];
      for ($date = Carbon::now()->subDays(6); $date <= Carbon::now(); $date->addDay()) {
        $dates[] = $date->format('Y-m-d');
        $xaxis[] = $date->dayName;
        $posts_yaxis[] = $posts_data[$date->format('Y-m-d')] ?? 0;
        $chats_yaxis[] = $chats_data[$date->format('Y-m-d')] ?? 0;
        $calls_yaxis[] = $calls_data[$date->format('Y-m-d')] ?? 0;
      }

      //dd($yaxis);

      return $this->chart->barChart()
    ->addData(__('New posts'), $posts_yaxis)
    ->addData(__('New chats'), $chats_yaxis)
    ->addData(__('New calls'), $calls_yaxis)
    ->setXAxis($xaxis)
    ->setStroke(width:1, curve:'smooth')
    ->setHeight(250)
    ->setFontFamily('Readex Pro')
    ->setFontColor(Session::get('theme') == 'dark' ? '#FFFFFF' : '#000000');
    }
}
