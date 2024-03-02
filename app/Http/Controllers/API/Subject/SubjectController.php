<?php

namespace App\Http\Controllers\API\Subject;

use App\Http\Controllers\Controller;
use App\Http\Resources\Subject\SubjectCollection;
use App\Repositories\Subject\SubjectRepository;
use Illuminate\Http\Request;
use Exception;
class SubjectController extends Controller
{
    private $subject;

    public function __construct(SubjectRepository $subject){
      $this->subject = $subject;
    }

    public function getSubject(){
      try
      {
        $subject = $this->subject->all();

        return response()->json([
          'status' => true,
          'subject' => new SubjectCollection($subject)
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
