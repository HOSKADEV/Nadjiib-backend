<?php

namespace App\Http\Controllers\API\Section;

use App\Http\Controllers\Controller;
use App\Http\Resources\Section\PaginateSectionCollection;
use App\Repositories\Section\SectionRepository;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

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
          $sections =  $this->sections->paginate(10);
          return response()->json([
            'status'   => true,
            'sections' => new PaginateSectionCollection($sections)
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

    public function searchSection(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'section_id' => 'require|exists:sections,id'
        ]);
        if ($validator->fails()) {
          return response()->json([
              'status' => false,
              'message' => $validator->errors()->first()
            ]);
        }
        try
        {
          
        }
        catch(Exception $e){
          return response()->json([
            'status' => 0,
            'message' => $e->getMessage()
          ]);
        }
    }
}
