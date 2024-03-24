<?php

namespace App\Http\Controllers\API\Subject;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Subject\SubjectRepository;
use App\Http\Resources\Subject\SubjectCollection;
use App\Http\Resources\Subject\PaginateSubjectCollection;

class SubjectController extends Controller
{
    private $subject;

    public function __construct(SubjectRepository $subject){
      $this->subject = $subject;
    }

    public function get(Request $request){

      $validator = Validator::make($request->all(), [
        'level_id' => 'sometimes|prohibits:type|exists:levels,id',
        'type' => 'sometimes|in:academic,extracurricular',
        'search' => 'sometimes|string',
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
        $subject = $request->has('level_id')?
        $this->subject->getByLevel($request->level_id):
        $this->subject->table();

        if($request->has('type')){
          $subject = $subject->whereType($request->type);
        }

        if($request->has('search')){
          $subject = $subject->where(function ($query) use($request) {
            $query->where('name_ar', 'like', '%' . $request->search . '%')
                ->orWhere('name_en', 'like', '%' . $request->search . '%')
                ->orWhere('name_fr', 'like', '%' . $request->search . '%');
        });
        }

        return response()->json([
          'status' => 1,
          'data' => new SubjectCollection($subject->get())
        ]);
      }
      catch(Exception $e)
      {
        return response()->json([
          'status'  => 0,
          'message' => $e->getMessage()
        ]);
      }
    }
}
