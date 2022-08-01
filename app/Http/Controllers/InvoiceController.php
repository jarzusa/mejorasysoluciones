<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItems;
use App\Models\Items;
use App\Models\Receptor;
use App\Models\Trasmitter;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class InvoiceController extends Controller
{
  public function __construct(Request $request)
  {
    // User has to be logged in
    $this->middleware('auth:sanctum');
  }

  // Traigo todos los registros de factura
  public function all(Request $request)
  {

    try {
      $invoices = Invoice::all();

      if (count($invoices) > 0) {
        foreach ($invoices as $key => &$value) {
          $trasmitter  = Trasmitter::where(['id' => $value->trasmitter_id])->get();
          $receptor = Receptor::where(['id' => $value->receptor_id])->get();
          $items_details = InvoiceItems::where(['invoice_id' => $value->id])->get();
          if (count($items_details) > 0) {
            foreach ($items_details as $key => &$dValue) {
              $item = Items::where(['id' => $dValue->item_id])->get();
              $dValue["name"] = $item[0]->name;
            }
          }
          $value['trasmitter'] = (count($trasmitter) > 0) ? $trasmitter[0] : null;
          $value['receptor']  = (count($receptor) > 0) ? $receptor[0] : null;
          $value['details']  = (count($items_details) > 0) ? $items_details : [];
        }
      }
      return response()->json($invoices, 200);
    } catch (Exception $e) {
      return response()->json([
        'res'  => false,
        'msg' => $e->getMessage(),
      ], 500);
    }
  }

  // Guardar factura
  public function store(Request $request)
  {
    // Usuario logueado
    $currentUser = $request->user();
    try {
      $data = $request->all(); //Payload
      $last = Invoice::orderBy('creado', 'desc')->first(); //Ultima factura registrada
      $lastNroInvoice = explode("-", $last->nro_factura); //Divido el numero de factura para el consecutivo

      // Creo Factura
      $invoice = Invoice::create([
        'user_id' => $currentUser->id,
        'fecha' => Carbon::now(),
        'creado' => Carbon::now(),
        'actualizado' => Carbon::now(),
        'trasmitter_id' => $data["trasmitter"]["id"],
        'receptor_id' => $data["receptor"]["id"],
        'nro_factura' => 'FC-' . intval($lastNroInvoice[1]) + 1,
      ]);

      $subtotal = 0;

      // Valido y creo los items por factura
      foreach ($data['products'] as $key => $value) {
        $exist = Items::find($value['id']);
        if (isset($exist)) {
          $subtotal = $subtotal + ($exist->precio * $value['cant']); //Calculo IVA
          InvoiceItems::create([
            'invoice_id' => $invoice->id,
            'item_id' => $value['id'],
            'cantidad' => $value['cant'],
            'precio' => $exist->precio
          ]);
        }
      }

      $total = $subtotal + (intval($data["iva"]) * ($subtotal / 100)); //Guardo el total calculado

      $invoice->subtotal = $subtotal;
      $invoice->total = $total;
      $invoice->save();

      return response()->json([
        'success' => true,
        'data' => $invoice,
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'success'  => false,
        'error' => $e->getMessage(),
      ], 500);
    }
  }

  // Actualizar factura
  public function update(Invoice $invoice, Request $request)
  {
    $currentUser = $request->user();
    try {
      if ($currentUser->id !== $invoice->user_id) {
        throw new Exception('Accesso denegado');
      }
      $data = $request->all(); //Payload
   
      $invoice->iva = $data["iva"];
      $invoice->trasmitter_id = $data["trasmitter"]["id"];
      $invoice->receptor_id = $data["receptor"]["id"]; 
      $total = $invoice->subtotal + (intval($data["iva"]) * ($invoice->subtotal / 100)); //Guardo el total calculado
      $invoice->total = $total;
      $invoice->update();

      return response()->json([
        'success' => true,
        'data' => $invoice,
      ]);
    } catch (Exception $e) {
      return response()->json([
        'success'  => false,
        'error' => $e->getMessage(),
      ], 500);
    }
  }
}
