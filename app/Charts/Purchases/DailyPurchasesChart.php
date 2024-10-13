<?php

namespace App\Charts\Purchases;

use App\Models\Purchase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class DailyPurchasesChart
{
    protected $chart;

    public function __construct()
    {
        $this->chart = new LarapexChart();
    }

    public function build()
    {

      $data = Purchase::whereDate('created_at', '>=' , Carbon::now()->subDays(6))
      ->groupBy(DB::raw('DATE(created_at)'))
      ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(id) AS users'))
      ->get()->pluck( 'users','date')->all();

      $xaxis = [];
      $dates = [];
      $yaxis = [];
      for ($date = Carbon::now()->subDays(6); $date <= Carbon::now(); $date->addDay()) {
        $dates[] = $date->format('Y-m-d');
        $xaxis[] = $date->dayName;
        $yaxis[] = $data[$date->format('Y-m-d')] ?? 0;
      }

      //dd($yaxis);

      return $this->chart->areaChart()
    ->addData(__('New purchases'), $yaxis)
    ->setXAxis($xaxis)
    //->setSparkline()
    ->setStroke(width:4, curve:'smooth')
    ->setHeight(250)
    ->setDataLabels(true)
    ->setFontFamily('Readex Pro')
    ->setFontColor(Session::get('theme') == 'dark' ? '#FFFFFF' : '#000000')
    ->setColors(['#007FFC']);
    }
}
