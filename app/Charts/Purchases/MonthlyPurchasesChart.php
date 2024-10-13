<?php

namespace App\Charts\Purchases;

use App\Models\Purchase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class MonthlyPurchasesChart
{
    protected $chart;

    public function __construct()
    {
        $this->chart = new LarapexChart();
    }

    public function build()
    {

      $db_data = Purchase::whereDate('created_at', '>=' , Carbon::now()->subMonths(5)->firstOfMonth())
      ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
      ->select(DB::raw('YEAR(created_at) as year'), DB::raw('MONTH(created_at) AS month'), DB::raw('COUNT(id) AS users'))
      ->get()->toArray();

      $data = [];

      foreach($db_data as $item){
        $data[Carbon::createFromDate($item['year'] . '-' . $item['month'] .'-1')->format('Y-m-d')] = $item['users'];
      }

      //dd($data);

      $xaxis = [];
      $dates = [];
      $yaxis = [];
      for ($date = Carbon::now()->subMonths(5)->firstOfMonth(); $date <= Carbon::now(); $date->addMonth()) {
        $dates[] = $date->format('Y-m-d');
        $xaxis[] = $date->monthName;
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
