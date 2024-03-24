<?php

namespace App\Http\Controllers\API\Levels;

use App\Http\Controllers\Controller;
use App\Http\Resources\Levels\LevelCollection;
use App\Http\Resources\Levels\PaginatedLevelCollection;
use App\Repositories\Level\LevelRepository;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

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
        'section_id' => 'required|exists:sections,id',
      ]);

      if ($validator->fails()) {
        return response()->json(
          [
            'status' => 0,
            'message' => $validator->errors()->first()
          ]
        );
      }

        try
        {


          $levels = $this->levels->getBySection($request->section_id);

            return response()->json([
              'status' => 1,
              'data' => new LevelCollection($levels)
            ]);
        }
        catch(Exception $e)
        {
          return response()->json([
            'status' => 0,
            'message' => $e->getMessage()
          ]);
        }
    }


}
