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

      return response()->json([
        'status' => 1,
        'data' => new SectionCollection($sections)
      ]);
    } catch (Exception $e) {
      return response()->json([
        'status' => 0,
        'message' => $e->getMessage()
      ]);
    }
  }
}
