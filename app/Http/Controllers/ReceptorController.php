<?php

namespace App\Http\Controllers;

use App\Models\Receptor;
use Illuminate\Http\Request;

class ReceptorController extends Controller
{
    public function __construct(Request $request)
    {
      // User has to be logged in
      $this->middleware('auth:sanctum');
    }
    
    public function all(Request $request)
    {
  
      try {
        $receptors = Receptor::all();
        return response()->json($receptors, 200);
      } catch (Exception $e) {
        return response()->json([
          'res'  => false,
          'msg' => $e->getMessage(),
        ], 500);
      }
    }
}
