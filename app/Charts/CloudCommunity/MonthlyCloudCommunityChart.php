<?php

namespace App\Charts\CloudCommunity;

use App\Models\Call;
use App\Models\Chat;
use App\Models\Post;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class MonthlyCloudCommunityChart
{
    protected $chart;

    public function __construct()
    {
        $this->chart = new LarapexChart();
    }

    public function build()
    {

      $posts_db_data = Post::whereDate('created_at', '>=' , Carbon::now()->subMonths(5)->firstOfMonth())
      ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
      ->select(DB::raw('YEAR(created_at) as year'), DB::raw('MONTH(created_at) AS month'), DB::raw('COUNT(id) AS posts'))
      ->get()->toArray();

      $chats_db_data = Chat::whereDate('created_at', '>=' , Carbon::now()->subMonths(5)->firstOfMonth())
      ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
      ->select(DB::raw('YEAR(created_at) as year'), DB::raw('MONTH(created_at) AS month'), DB::raw('COUNT(id) AS chats'))
      ->get()->toArray();

      $calls_db_data = Call::whereDate('created_at', '>=' , Carbon::now()->subMonths(5)->firstOfMonth())
      ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
      ->select(DB::raw('YEAR(created_at) as year'), DB::raw('MONTH(created_at) AS month'), DB::raw('COUNT(id) AS calls'))
      ->get()->toArray();

      $posts_data = [];
      $chats_data = [];
      $calls_data = [];

      foreach($posts_db_data as $item){
        $posts_data[Carbon::createFromDate($item['year'] . '-' . $item['month'] .'-1')->format('Y-m-d')] = $item['posts'];
      }

      foreach($chats_db_data as $item){
        $chats_data[Carbon::createFromDate($item['year'] . '-' . $item['month'] .'-1')->format('Y-m-d')] = $item['chats'];
      }

      foreach($calls_db_data as $item){
        $calls_data[Carbon::createFromDate($item['year'] . '-' . $item['month'] .'-1')->format('Y-m-d')] = $item['calls'];
      }

      //dd($data);

      $xaxis = [];
      $dates = [];
      $posts_yaxis = [];
      $chats_yaxis = [];
      $calls_yaxis = [];
      for ($date = Carbon::now()->subMonths(5)->firstOfMonth(); $date <= Carbon::now(); $date->addMonth()) {
        $dates[] = $date->format('Y-m-d');
        $xaxis[] = $date->monthName;
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
