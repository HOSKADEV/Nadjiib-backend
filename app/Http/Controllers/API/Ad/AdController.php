<?php

namespace App\Http\Controllers\API\Ad;

use Exception;
use App\Models\Ad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Ad\AdCollection;
use Illuminate\Support\Facades\Validator;

class AdController extends Controller
{

  public function get(Request $request){  //paginated
    $validator = Validator::make($request->all(), [
      'search' => 'sometimes',
      'type' => 'sometimes|in:url,course,teacher',
    ]);

    if ($validator->fails()){
      return response()->json([
          'status' => 0,
          'message' => $validator->errors()->first()
        ]
      );
    }

    try{

    $ads = Ad::orderBy('created_at','DESC');

    if($request->has('type')){

      $ads = $ads->where('type', $request->type);
    }

    if($request->has('search')){

      $ads = $ads->where('name', 'like', '%' . $request->search . '%');
    }

    $ads = $ads->paginate(10);

    //return($ads);

    return response()->json([
      'status' => 1,
      'message' => 'success',
      'data' => new AdCollection($ads)
    ]);

  }catch(Exception $e){
    return response()->json([
      'status' => 0,
      'message' => $e->getMessage()
    ]
  );
  }

  }
}
