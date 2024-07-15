<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
  public function info(){
    try {

      $data = [
        'ccp' => 'XXXXXXXXXXXXXXXXX',
        'baridi_mob' => 'XXXXXXXXXXXXXXXXX',
      ];

      return response()->json([
        'status' => true,
        'message' => 'success',
        'data' => $data
      ]);

    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }
}
