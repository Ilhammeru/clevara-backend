<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index() {
        $data = Cart::with('product:id,name', 'product.image:product_id,file_url,folder', 'product.price:product_id,price')
                    ->select('id', 'qty', 'price', 'total', 'product_id')
                    ->where('status', 1)->orderBy('created_at', 'asc')->get();

        if (count($data) == 0) {
            return response()->json([
                'data'	    => [],
                'message'   => 'Cart empty',
                'success'   => false
            ]);
        }

        foreach ($data as $a) {
            $response[] = [
                'id'    => $a->id,
                'name'  => $a->product->name,
                'qty'   => $a->qty,
                'price' => 'Rp. ' . number_format($a->product->price->price),
                'image' => $a->product->image[0]->file_url,
                'folder'=> $a->product->image[0]->folder,
                'total' => $a->total
            ];
        }

        return response()->json([
            'data'	    => $response,
            'success'   => true,
            'message'   => "Data Found"
        ]);
    }

    public function store(Request $request) {
        $store = [
            'product_id'    => $request->productId,
            'customer_id'   => 1,
            'qty'           => $request->qty,
            'price'         => $this->mask($request->price),
            'total'         => $this->mask($request->subtotal),
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ];

        $check = Cart::where('product_id', $request->productId)->where('status', 1)->first();
        $request->price = $this->mask($request->price);
        $request->subtotal = $this->mask($request->subtotal);
        if ($check != null) {
            $request->qty = $request->qty + $check->qty;
            $request->subtotal = $request->qty * $request->price;
        }

        DB::beginTransaction();

        try {
            Cart::updateOrCreate(
                ['product_id' => $request->productId, 'status' => 1],
                ['customer_id' => '1', 'qty' => $request->qty, 'total' => $request->subtotal, 'price' => $request->price, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()]
            );        
            
            DB::commit();

            return response()->json([
                'data'	    => [],
                'message'   => $request->name . ' has been successfully added to the cart',
                'success'   => true
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'data'	    => [],
                'message'   => $th->getMessage(),
                'success'   => false
            ]);
        }


    }

    public function mask($param) {
        $replace = str_replace('Rp. ', '', $param);
        $replace = str_replace(',', '', $replace);

        return $replace;
    }

    public function update(Request $request) {
        $update = Cart::where('id', $request->id)->first();
        $update->qty = $request->qty;
        $update->total = $request->qty * $update->price;
        $update->updated_at = Carbon::now();

        if ($update->save()) {
            $data = Cart::with('product:id,name', 'product.image:product_id,file_url,folder', 'product.price:product_id,price')
                    ->select('id', 'qty', 'price', 'total', 'product_id')
                    ->where('status', 1)->orderBy('created_at', 'asc')->get();

            foreach ($data as $a) {
                $response[] = [
                    'id'    => $a->id,
                    'name'  => $a->product->name,
                    'qty'   => $a->qty,
                    'price' => 'Rp. ' . number_format($a->product->price->price),
                    'image' => $a->product->image[0]->file_url,
                    'folder'=> $a->product->image[0]->folder,
                    'total' => $a->total
                ];
            }
            return response()->json([
                'data'	    => $response,
                'message'   => 'Data update',
                'success'   => true
            ], 201);
        }

        return response()->json([
            'data'	    => [],
            'message'   => 'Failed to update',
            'success'   => false
        ], 401);
    }
}
