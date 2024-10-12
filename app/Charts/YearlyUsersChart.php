<?php

namespace App\Charts;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class YearlyUsersChart
{
    protected $chart;

    public function __construct()
    {
        $this->chart = new LarapexChart();
    }

    public function build()
    {

      $data = User::whereDate('created_at', '>=' , Carbon::now()->subYears(4))
      ->groupBy(DB::raw('YEAR(created_at)'))
      ->select(DB::raw('YEAR(created_at) as year'), DB::raw('COUNT(id) AS users'))
      ->get()->pluck( 'users','year')->all();

      $xaxis = [];
      $dates = [];
      $yaxis = [];
      for ($date = Carbon::now()->subYears(4); $date <= Carbon::now(); $date->addYear()) {
        $dates[] = $date->year;
        $xaxis[] = $date->year;
        $yaxis[] = $data[$date->year] ?? 0;
      }

      //dd($yaxis);

      return $this->chart->lineChart()
    ->addData(__('New users'), $yaxis)
    ->setXAxis($xaxis)
    //->setSparkline()
    ->setStroke(width:4, curve:'smooth')
    ->setHeight(250)
    ->setDataLabels(true)
    ->setFontFamily('Readex Pro')
    ->setColors(['#303F9F']);
    }
}
