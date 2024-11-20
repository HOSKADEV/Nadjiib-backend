<?php

namespace App\Http\Controllers\API\Notification;

use Exception;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Notification\NotificationResource;
use App\Http\Resources\Notification\NotificationCollection;

class NotificationController extends Controller
{

  public function create(Request $request){
    $validator = Validator::make($request->all(), [
      'user_id' => 'required|integer|exists:users,id',
      'type' => 'sometimes|in:1,2,3,4,5,6,7,8',
    ]);

    if ($validator->fails()) {
      return response()->json(
        [
          'status' => false,
          'message' => $validator->errors()->first()
        ]
      );
    }

    try {

      $user = User::find($request->user_id);

      $notification = $user->notify($request->type);


      return response()->json([
        'status' => true,
        'message' => 'success',
        'data' => new NotificationResource($notification)
      ]);

    } catch (Exception $e) {
      return response()->json(
        [
          'status' => false,
          'message' => $e->getMessage()
        ]
      );
    }
  }

  public function read(Request $request){
    $validator = Validator::make($request->all(), [
      'notification_id' => 'required|integer|exists:notifications,id',
    ]);

    if ($validator->fails()) {
      return response()->json(
        [
          'status' => false,
          'message' => $validator->errors()->first()
        ]
      );
    }

    try {

      $notification = Notification::find($request->notification_id);

      $notification->is_read = 'yes';
      $notification->read_at = Carbon::now();
      $notification->save();

      return response()->json([
        'status' => true,
        'message' => 'success',
        'data' => new NotificationResource($notification)
      ]);

    } catch (Exception $e) {
      return response()->json(
        [
          'status' => false,
          'message' => $e->getMessage()
        ]
      );
    }
  }
  public function get(Request $request)
  { //paginated

    $request->mergeIfMissing([
      'user_id' => auth()->user()->id,
    ]);

    $validator = Validator::make($request->all(), [
      'user_id' => 'required|integer|exists:users,id',
      'is_read' => 'sometimes|in:yes,no',

    ]);

    if ($validator->fails()) {
      return response()->json(
        [
          'status' => false,
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
        'status' => true,
        'message' => 'success',
        'data' => $notifications
      ]);

    } catch (Exception $e) {
      return response()->json(
        [
          'status' => false,
          'message' => $e->getMessage()
        ]
      );
    }

  }
}
