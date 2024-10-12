<?php

namespace App\Charts;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class UserStatusChart
{
    protected $chart;

    public function __construct()
    {
        $this->chart = new LarapexChart();
    }

    public function build()
    {

      $data = User::whereNot('role', 0)
      ->whereNot('status', 'DELETED')
      ->groupBy('role')
      ->select('role', DB::raw('COUNT(id) as users'))
      ->pluck('users', 'role')->toArray();

      $xaxis = [];
      $yaxis = [];
      foreach ($data as $key => $item) {
        $xaxis[] = __('user_role_' . $key);
        $yaxis[] = $item;
      }

      //dd($yaxis);
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
