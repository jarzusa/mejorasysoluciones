<?php

namespace App\Http\Controllers;

use App\Models\Trasmitter;
use Illuminate\Http\Request;

class TransmitterController extends Controller
{
    public function __construct(Request $request)
    {
      // User has to be logged in
      $this->middleware('auth:sanctum');
    }
    
    public function all(Request $request)
    {
  
      try {
        $trasmitter = Trasmitter::all();
        return response()->json($trasmitter, 200);
      } catch (Exception $e) {
        return response()->json([
          'res'  => false,
          'msg' => $e->getMessage(),
        ], 500);
      }
    }
}
