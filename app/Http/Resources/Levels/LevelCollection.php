<?php

namespace App\Http\Resources\Levels;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LevelCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
      $levels = parent::toArray($request);

        $years = [];

        foreach($levels as $level){
          if(!in_array($level[ 'year'],$years)){
            array_push($years, $level[ 'year']);
          }
        }

        $data = [];

        foreach($years as $year){
          $array = [
            'year' => $year,
            'levels' => []
          ];
          foreach($levels as $level){
            if($level[ 'year'] == $year){
              array_push($array['levels'], $level);
              $array['year'] = $level['name'];
            }
          }
          array_push($data, $array);
        }

        return $data;
    }
}
