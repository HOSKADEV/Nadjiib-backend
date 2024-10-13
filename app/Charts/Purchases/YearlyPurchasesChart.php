<?php

namespace App\Charts\Purchases;

use App\Models\Purchase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class YearlyPurchasesChart
{
    protected $chart;

    public function __construct()
    {
        $this->chart = new LarapexChart();
    }

    public function build()
    {

      $data = Purchase::whereDate('created_at', '>=' , Carbon::now()->subYears(4))
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
