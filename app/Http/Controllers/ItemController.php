<?php

namespace App\Http\Controllers;

use App\Models\Items;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function __construct(Request $request)
    {
      // User has to be logged in
      $this->middleware('auth:sanctum');
    }
    
    public function all(Request $request)
    {
  
      try {
        $items = Items::all();
        return response()->json($items, 200);
      } catch (Exception $e) {
        return response()->json([
          'res'  => false,
          'msg' => $e->getMessage(),
        ], 500);
      }
    }
}
