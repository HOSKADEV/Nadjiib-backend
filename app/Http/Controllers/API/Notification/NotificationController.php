<?php

namespace App\Http\Controllers\API\Notification;

use Exception;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Notification\NotificationCollection;

class NotificationController extends Controller
{
  public function get(Request $request)
  { //paginated

    $request->mergeIfMissing([
      'user_id' => auth()->user()->id,
    ]);

    $validator = Validator::make($request->all(), [
      'user_id' => 'required|integer|exists:users,id',
      'is_read' => 'sometimes|in:0,1',

    ]);

    if ($validator->fails()) {
      return response()->json(
        [
          'status' => 0,
          'message' => $validator->errors()->first()
        ]
      );
    }

    try {

      $notifications = Notification::orderBy('created_at', 'DESC');

      if ($request->has('user_id')) {
        $notifications = $notifications->where('user_id', $request->user_id);
      }

      if ($request->has('is_read')) {
        $notifications = $notifications->where('is_read', $request->is_read);
      }

      $notifications = new NotificationCollection($notifications->paginate(10));



      return response()->json([
        'status' => 1,
        'message' => 'success',
        'data' => $notifications
      ]);

    } catch (Exception $e) {
      return response()->json(
        [
          'status' => 0,
          'message' => $e->getMessage()
        ]
      );
    }

  }
}
