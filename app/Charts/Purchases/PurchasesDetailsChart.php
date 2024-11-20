<?php

namespace App\Charts\Purchases;

use App\Models\Purchase;
use App\Models\PurchaseBonus;
use App\Models\PurchaseCoupon;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class PurchasesDetailsChart
{
    protected $chart;
    protected $year;

    public function __construct($year)
    {
        $this->chart = new LarapexChart();
        $this->year = $year;
    }

    public function build()
    {

      $purchases_db_data = Purchase::whereYear('created_at', $this->year)->where('status', 'success')
      ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
      ->select(DB::raw('YEAR(created_at) as year'), DB::raw('MONTH(created_at) AS month'), DB::raw('SUM(price) AS amount'))
      ->get()->toArray();

      $discounts_db_data = PurchaseCoupon::whereYear('created_at', $this->year)->whereHas('purchase', function($query){
        $query->where('status', 'success');
      })
      ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
      ->select(DB::raw('YEAR(created_at) as year'), DB::raw('MONTH(created_at) AS month'), DB::raw('SUM(amount) AS amount'))
      ->get()->toArray();

      $bonuses_db_data = PurchaseBonus::whereYear('created_at', $this->year)->whereHas('purchase', function($query){
        $query->where('status', 'success');
      })
      ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
      ->select(DB::raw('YEAR(created_at) as year'), DB::raw('MONTH(created_at) AS month'), DB::raw('SUM(amount) AS amount'))
      ->get()->toArray();

      $purchases_data = [];
      $discounts_data = [];
      $bonuses_data = [];

      foreach($discounts_db_data as $item){
        $discounts_data[Carbon::createFromDate($item['year'] . '-' . $item['month'] .'-1')->format('Y-m-d')] = $item['amount'];
      }

      foreach($bonuses_db_data as $item){
        $bonuses_data[Carbon::createFromDate($item['year'] . '-' . $item['month'] .'-1')->format('Y-m-d')] = $item['amount'];
      }

      foreach($purchases_db_data as $item){
        $key = Carbon::createFromDate($item['year'] . '-' . $item['month'] .'-1')->format('Y-m-d');
        $purchases_data[$key] = $item['amount']??0 - $discounts_data[$key]??0 - $bonuses_data[$key]??0;
      }

      //dd($data);

      $xaxis = [];
      $dates = [];
      $purchases_yaxis = [];
      $discounts_yaxis = [];
      $bonuses_yaxis = [];
      for ($date = Carbon::createFromDate($this->year . '-01-01'); $date->year == $this->year; $date->addMonth()) {
        $dates[] = $date->format('Y-m-d');
        $xaxis[] = $date->monthName;
        $purchases_yaxis[] = $purchases_data[$date->format('Y-m-d')] ?? 0;
        $discounts_yaxis[] = $bonuses_data[$date->format('Y-m-d')] ?? 0;
        $bonuses_yaxis[] = $discounts_data[$date->format('Y-m-d')] ?? 0;
      }

      //dd($yaxis);

      return $this->chart->barChart()
    ->addData(__('Gross income'), $purchases_yaxis)
    ->addData(__('Total discounts'), $discounts_yaxis)
    ->addData(__('Total bonuses'), $bonuses_yaxis)
    ->setXAxis($xaxis)
    ->setStacked(true)
    ->setStroke(width:1, curve:'smooth')
    ->setHeight(250)
    ->setFontFamily('Readex Pro')
    ->setFontColor(Session::get('theme') == 'dark' ? '#FFFFFF' : '#000000');
    }
}
