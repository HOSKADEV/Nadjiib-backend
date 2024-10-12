<?php

namespace App\Charts;

use App\Models\Purchase;
use Illuminate\Support\Facades\DB;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class PurchaseStatusChart
{
    protected $chart;

    public function __construct()
    {
        $this->chart = new LarapexChart();
    }

    public function build()
    {

      $data = Purchase::
      groupBy('status')
      ->select('status', DB::raw('COUNT(id) as purchases'))
      ->pluck('purchases', 'status')->toArray();

      $xaxis = [];
      $yaxis = [];
      foreach ($data as $key => $item) {
        $xaxis[] = __('purchase_status_' . $key);
        $yaxis[] = $item;
      }

      //dd($xaxis);
        return $this->chart->pieChart()
            //->setTitle('Top 3 scorers of the team.')
            //->setSubtitle('Season 2021.')
            ->addData($yaxis)
            ->setLabels($xaxis)
            ->setHeight(160)
            ->setWidth(280)
            ->setFontFamily('Readex Pro');
    }
}
