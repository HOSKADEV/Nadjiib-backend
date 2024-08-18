<?php

namespace App\Http\Controllers\API\Version;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Version\VersionResource;

class VersionController extends Controller
{
  public function get(){

    try{

      $version = new VersionResource(null);

      return response()->json([
        'status' => 1,
        'message' => 'success',
        'data' => $version,
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
