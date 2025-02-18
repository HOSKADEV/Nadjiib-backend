<?php

namespace App\Http\Controllers\API\Levels;

use Exception;
use App\Models\Level;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\YearCollection;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Level\LevelRepository;
use App\Http\Resources\Levels\LevelCollection;
use App\Http\Resources\Levels\PaginatedLevelCollection;

class LevelController extends Controller
{
    private $levels;
    public function __construct(LevelRepository $levels)
    {
        $this->levels = $levels;
    }

    public function get(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'sections' => 'required|array',
          'sections.*' => 'exists:sections,id'
        ]);

        if ($validator->fails()) {
          return response()->json(
            [
              'status'  => false,
              'message' => $validator->errors()->first()
            ]
          );
        }

        try
        {
          $levels = Level::whereIn('section_id', $request->sections)
                          ->select('section_id', 'year', 'name_ar', 'name_fr', 'name_en')
                          ->groupBy('section_id', 'year', 'name_ar', 'name_fr', 'name_en')
                          ->get();
          //return($levels);
            return response()->json([
              'status' => true,
              'data'   => new YearCollection($levels)
            ]);
        }
        catch(Exception $e)
        {
          return response()->json([
            'status'  => false,
            'message' => $e->getMessage()
          ]);
        }
    }
}
