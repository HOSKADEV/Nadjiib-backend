<?php

namespace App\Http\Controllers\API\Section;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Section\SectionRepository;
use App\Http\Resources\Section\SectionCollection;
use App\Http\Resources\Section\PaginateSectionCollection;

class SectionController extends Controller
{
  private $sections;

  public function __construct(SectionRepository $sections)
  {
    $this->sections = $sections;
  }

  public function get(Request $request)
  {
    try {
      $sections = $this->sections->all();

      if (count($sections) == 0) {
          return response()->json([
            'status' => false,
            'message' => 'No data found'
          ], 404);
      }

      return response()->json([
        'status' => true,
        'data'   => new SectionCollection($sections)
      ], 200);
    }
    catch (Exception $e) {
      return response()->json([
        'status'  => false,
        'message' => $e->getMessage()
      ]);
    }
  }
}
