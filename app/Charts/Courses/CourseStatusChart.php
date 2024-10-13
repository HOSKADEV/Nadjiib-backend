<?php

namespace App\Charts\Courses;

use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class CourseStatusChart
{
    protected $chart;

    public function __construct()
    {
        $this->chart = new LarapexChart();
    }

    public function build()
    {

      $data = Course::
      groupBy('status')
      ->select('status', DB::raw('COUNT(id) as courses'))
      ->pluck('courses', 'status')->toArray();

      $xaxis = [];
      $yaxis = [];
      foreach ($data as $key => $item) {
        $xaxis[] = __('course_status_' . $key);
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
            ->setFontFamily('Readex Pro')
    ->setFontColor(Session::get('theme') == 'dark' ? '#FFFFFF' : '#000000');
    }
}
