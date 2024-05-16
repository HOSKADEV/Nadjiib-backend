<?php

namespace App\Http\Controllers\API\Wishlist;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Wishlist\WishlistCollection;
use App\Http\Resources\Wishlist\WishlistResource;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Wishlist\WishlistRepository;
use Exception;
class WishlistController extends Controller
{
    private $wishlist;

    public function __construct(WishlistRepository $wishlist)
    {
        $this->wishlist = $wishlist;
    }
    public function get(Request $request)
    {
        $validtion = Validator::make($request->all(),[
          'student_id' => 'required|exists:students,id',
        ]);
        if ($validtion->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validtion->errors()
            ], 403);
        }

        try {
            $wishlists = $this->wishlist->getByStudent($request->student_id);
            dd($wishlists);
            if (!$wishlists) {
              return response()->json([
                'status' => false,
                'message' => 'student not found in wishlist'
              ]);
            }
            else {
              $data = [];
              foreach ($wishlists as $wishlist) {
                $data[] = [
                  'id' => $wishlist->id,
                  'course' => [
                    'id'   => $wishlist->course->id,
                    'name' => $wishlist->course->name,
                    'price' => $wishlist->course->price,
                    'image' => is_null($wishlist->course->image) ? null : url($wishlist->course->image),
                  ],
                  'created' => $wishlist->created_at->format('d-m-Y'),
                ];
              }

              return response()->json([
                'status' => true,
                'data' => $data,
                'count' => $wishlist->count()
              ]);
            }



        }
        catch(Exception $e){
          return response()->json([
            'status'  => false,
            'message' => $e->getMessage()
          ]);
        }
    }

    public function create(Request $request)
    {
        $validtion = Validator::make($request->all(),[
          'course_id'  => 'required|exists:courses,id',
          'student_id' => 'required|exists:students,id',
        ]);
        if ($validtion->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validtion->errors()
            ], 403);
        }

        try {
          $wishlist = $this->wishlist->create($request->all());
          if (!$wishlist) {
            return response()->json([
              'status'  => false,
              'message' => 'Something went wrong'
            ]);
          }
          else {
              return response()->json([
                'status'  => true,
                'message' => 'Wishlist created successfully',
                'data' => $wishlist
              ]);
          }

        }
        catch(Exception $e){
          return response()->json([
            'status'  => false,
            'message' => $e->getMessage()
          ]);
        }
    }

    public function delete(Request $request)
    {
        $validtion = Validator::make($request->all(),[
          'wishlist_id'  => 'required|exists:wishlists,id',
        ]);
        if ($validtion->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validtion->errors()
            ], 403);
        }

        try {
            $wishlist = $this->wishlist->delete($request->wishlist_id);

            if (!$wishlist) {
                return response()->json([
                  'status' => false,
                  'message' => 'Something went wrong'
                ]);
            }

            return response()->json([
                'status'  => true,
                'message' => 'Wishlist deleted successfully',
            ]);
        }
        catch(Exception $e){
          return response()->json([
            'status'  => false,
            'message' => $e->getMessage()
          ]);
        }
    }
}
