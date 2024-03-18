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
    public function getLevel()
    {
        try
        {
            $levels = $this->levels->paginate(10);
            return response()->json([
              'status' => true,
              'level' => new PaginatedLevelCollection($levels)
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

    public function levelBySection(Request $request)
    {
        $validation = Validator::make($request->all(), [
          'section_id' => 'required|exists:sections,id'
        ]);
        if ($validation->fails()) {
          return response()->json([
            "status" => false,
            'message' => 'Invalid data sent',
            "errors" => $validation->errors()->getMessages(),
          ],422);
        }
        try{
            $level = $this->levels->getBySection($request->section_id);
            return response()->json([
              'status' => true,
              'lavel'  => new LevelCollection($level)
            ]);
        }
        catch(Exception $e){
          return response()->json([
            'status' => 0,
            'message' => $e->getMessage()
          ]);
        }
    }

}
