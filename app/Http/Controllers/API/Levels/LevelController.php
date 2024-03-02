<?php

namespace App\Http\Controllers\API\Levels;

use App\Http\Controllers\Controller;
use App\Http\Resources\Levels\LevelCollection;
use App\Http\Resources\Levels\PaginatedLevelCollection;
use App\Repositories\Level\LevelRepository;
use Illuminate\Http\Request;
use Exception;
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
            $levels = $this->levels->all();
            // $levels = $this->levels->paginate(20);

            return response()->json([
              'status' => true,
              'levels' => new LevelCollection($levels)
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
