<?php

namespace App\Http\Controllers\API\Section;

use App\Http\Controllers\Controller;
use App\Http\Resources\Section\PaginateSectionCollection;
use App\Http\Resources\Section\SectionCollection;
use App\Repositories\Section\SectionRepository;
use Illuminate\Http\Request;
use Exception;

class SectionController extends Controller
{
    private $sections;

    public function __construct(SectionRepository $sections)
    {
      $this->sections = $sections;
    }

    public function getSection()
    {
      try {
          // $sections =  $this->sections->paginate(5);
          $sections =  $this->sections->all();
          return response()->json([
            'status'   => true,
            'sections' => new SectionCollection($sections)
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
