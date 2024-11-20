<?php

namespace App\Charts\CloudCommunity;

use App\Models\Call;
use App\Models\Chat;
use App\Models\Post;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class YearlyCloudCommunityChart
{
    protected $chart;

    public function __construct()
    {
        $this->chart = new LarapexChart();
    }

    public function build()
    {

      $posts_data = Post::whereDate('created_at', '>=' , Carbon::now()->subYears(4))
      ->groupBy(DB::raw('YEAR(created_at)'))
      ->select(DB::raw('YEAR(created_at) as year'), DB::raw('COUNT(id) AS posts'))
      ->get()->pluck( 'posts','year')->all();

      $chats_data = Chat::whereDate('created_at', '>=' , Carbon::now()->subYears(4))
      ->groupBy(DB::raw('YEAR(created_at)'))
      ->select(DB::raw('YEAR(created_at) as year'), DB::raw('COUNT(id) AS chats'))
      ->get()->pluck( 'chats','year')->all();

      $calls_data = Call::whereDate('created_at', '>=' , Carbon::now()->subYears(4))
      ->groupBy(DB::raw('YEAR(created_at)'))
      ->select(DB::raw('YEAR(created_at) as year'), DB::raw('COUNT(id) AS calls'))
      ->get()->pluck( 'calls','year')->all();

      $xaxis = [];
      $dates = [];
      $posts_yaxis = [];
      $chats_yaxis = [];
      $calls_yaxis = [];
      for ($date = Carbon::now()->subYears(4); $date <= Carbon::now(); $date->addYear()) {
        $dates[] = $date->year;
        $xaxis[] = $date->year;
        $posts_yaxis[] = $posts_data[$date->year] ?? 0;
        $chats_yaxis[] = $chats_data[$date->year] ?? 0;
        $calls_yaxis[] = $calls_data[$date->year] ?? 0;
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
