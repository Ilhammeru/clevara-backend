<?php

namespace App\Http\Controllers;

use App\Mail\CheckoutMail;
use App\Models\Cart;
use App\Models\Courier;
use App\Models\Customer;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index() {
        $data = Order::with('customer:id,name,address')
                    ->with('cart.product.image:product_id,file_url,folder')
                    ->with('cart.product:id,name')
                    ->with('cart:id,product_id,qty,price,total')
                    ->select(
                        'cart_id',
                        'status',
                        'customer_id'
                    )
                    ->where('status', 2)
                    ->where('customer_id', 1)
                    ->get();

        if (count($data) == 0) {
            return response()->json([
                'data'	    => [],
                'message'   => 'Checkout failed',
                'success'   => false
            ], 401);
        }

        foreach ($data as $a) {
            $customer = $a->customer;
            $cartId[] = $a->cart_id;
            $product[] = [
                'id'    => $a->cart->product->id,
                'name'  => $a->cart->product->name,
                'qty'   => $a->cart->qty,
                'price' => $a->cart->price,
                'formatPrice' => 'Rp. ' . number_format($a->cart->price),
                'img'   => $a->cart->product->image[0]->file_url,
                'folder'=> $a->cart->product->image[0]->folder
            ];
            $total[] = $a->cart->total;
        }

        $subtotal = array_sum($total);

        // list courier
        $courier = Courier::select('id', 'name', 'price', 'estimation')->get();
        foreach ($courier as $c) {
            $listCourier[] = [
                'id'    => $c->id,
                'name'  => $c->name,
                'price' => $c->price,
                'estimation'    => $c->estimation,
                'formatPrice'   => 'Rp. ' . number_format($c->price)
            ];
        }

        $response['customer']   = $customer;
        $response['product']    = $product;
        $response['subtotal']   = $subtotal;
        $response['courier']    = $listCourier;
        $response['cartId']     = $cartId;

        return response()->json([
            'data'	    => $response,
            'message'   => 'Data found',
            'success'   => true
        ], 201);
    }

    public function preCheckout(Request $request) {
        DB::beginTransaction();
        $data = $request->all();
        try {
            for($i = 0; $i < count($data); $i++) {
                $insert[] = [
                    'cart_id'       => $data[$i]['id'],
                    'customer_id'   => 1,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now()
                ];

                // update status to 2 in cart table
                Cart::where('id', $data[$i]['id'])->update([
                    'status'    => 2,
                    'updated_at'=> Carbon::now()
                ]);
            }
            Order::insert($insert);

            DB::commit();

            return response()->json([
                'data'	    => [],
                'message'   => 'Success insert data',
                'success'   => true 
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'data'	    => [],
                'message'   => $th->getMessage(),
                'success'   => false
            ], 401);
        }
    }

    public function checkout(Request $request) {
        $data = $request->all();

        DB::beginTransaction();

        try {
            $where = '';
            for ($a = 0; $a < count($data['cartId']); $a++) {
                Order::where('cart_id', $data['cartId'][$a])->update([
                    'updated_at' => Carbon::now(),
                    'status'     => 1,
                    'courier_id' => $data['courier'],
                    'payment_method'   => $data['payment'] == 2 ? 'BCA' : 'Mandiri',
                    'va_number'    => rand(10000, 999999)
                ]);
    
                Cart::where("id", $data['cartId'][$a])->update([
                    'updated_at' => Carbon::now(),
                    'status'    => 0
                ]);

                $where .= 'cart_id = ' . $data['cartId'][$a] . ' OR ';
            }

            $where .= ' cart_id = ' . $data['cartId'][0];
    
            //send email
            $dataOrder = Order::with('customer')
                    ->with('cart.product.price:product_id,price')
                    ->with('cart.product:id,name')
                    ->with('cart:id,qty,total,price,product_id')
                    ->with('courier')
                    ->whereRaw($where)
                    ->get();

            foreach ($dataOrder as $d) {
                $order[] = [
                    'name'  => $d->cart->product->name,
                    'qty'   => $d->cart->qty,
                    'price' => $d->cart->price,
                    'total' => $d->cart->qty * $d->cart->price
                ];
                $total[] = $d->cart->qty * $d->cart->price;
                $shipping = $d->courier->price;
            }

            $subtotal = array_sum($total);
            $grandTotal = $subtotal + $shipping;

            $mail = [
                'order' => $order,
                'subtotal'  => $subtotal,
                'shipping'  => $shipping,
                'grandTotal'=> $grandTotal
            ];
            Mail::to($data['email'])->send(new CheckoutMail($mail));
            
            DB::commit();
    
            return response()->json([
                'data'	=> $data,
                'message'   => 'Success Checkout',
                'success'   => true
            ], 201);
        
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'data'	=> [],
                'message'   => $th->getMessage(),
                'success'   => false
            ], 401);
        }
    }

    public function email() {
        $data = Order::with('customer')
                    ->with('cart.product.price:product_id,price')
                    ->with('cart.product:id,name')
                    ->with('cart:id,qty,total,price,product_id')
                    ->with('courier')
                    ->where('customer_id', 1)
                    ->get();

        foreach ($data as $d) {
            $order[] = [
                'name'  => $d->cart->product->name,
                'qty'   => $d->cart->qty,
                'price' => $d->cart->price,
                'total' => $d->cart->qty * $d->cart->price
            ];
            $total[] = $d->cart->qty * $d->cart->price;
            $shipping = $d->courier->price;
        }

        $subtotal = array_sum($total);
        $grandTotal = $subtotal + $shipping;

        $mail = [
            'order' => $order,
            'subtotal'  => $subtotal,
            'shipping'  => $shipping,
            'grandTotal'=> $grandTotal
        ];
        Mail::to('gumilang.dev@gmail.com')->send(new CheckoutMail($mail));
    }
}
