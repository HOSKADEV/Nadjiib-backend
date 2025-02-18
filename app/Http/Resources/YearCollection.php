<?php

namespace App\Http\Resources;

use App\Models\Level;
use App\Http\Resources\Levels\LevelCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class YearCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $years = parent::toArray($request);

        $data = [];

        foreach ($years as $year) {
          array_push($data, [
            'year' => match ($request->header('Accept-Language','ar')){
              'ar' => $year['name_ar'],
              'fr' => $year['name_fr'],
              'en' => $year['name_en'],
            },
            'levels' => new LevelCollection(Level::where($year)->get())
          ]);
        }

        return $data;

        //return parent::toArray($request);
    }
}
