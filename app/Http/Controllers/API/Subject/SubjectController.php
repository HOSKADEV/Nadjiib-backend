<?php

namespace App\Http\Controllers\API\Subject;

use App\Models\LevelSubject;
use Exception;
use App\Models\Level;
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
        'level_id'  => 'sometimes|prohibits:type,sections|exists:levels,id',
        'type'      => 'sometimes|in:academic,extracurricular',
        'sections'  => 'sometimes|array',
        'search'    => 'sometimes|string',
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
        $subject = $request->has('level_id')?
        $this->subject->getByLevel($request->level_id):
        $this->subject->table();

        if($request->has('type')){
          $subject = $subject->whereType($request->type);
        }

        if($request->has('sections')){
          $level_ids = Level::whereIn('section_id', $request->sections)->pluck('id')->toArray();
          $subject_ids = LevelSubject::whereIn('level_id',$level_ids)->distinct('subject_id')->pluck('subject_id')->toArray();
          $subject = $subject->whereIn('id', $subject_ids);
        }

        if($request->has('search')){
          $subject = $subject->where(function ($query) use($request) {
            $query->where('name_ar', 'like', '%' . $request->search . '%')
                ->orWhere('name_en', 'like', '%' . $request->search . '%')
                ->orWhere('name_fr', 'like', '%' . $request->search . '%');
        });
        }

        return response()->json([
          'status' => true,
          'data'   => new SubjectCollection($subject->get())
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
