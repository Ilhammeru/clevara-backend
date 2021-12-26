<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::with('price:product_id,price')->with('image:product_id,file_url')->select('id', 'name')->get();
        if (count($data) == 0) {
            return response()->json([
                'data'	    => [],
                'message'   => 'Data not found',
                'success'   => false
            ], 201);
        }

        foreach ($data as $d) {
            $all[] = [
                'id'    => $d->id,
                'name'  => $d->name,
                'price' => 'Rp. ' . number_format($d->price->price),
                'icon'  => $d->image[0]->file_url
            ];
        }

        for ($a = 0; $a < 4; $a++) {
            $bestSeller[] = $all[$a];
        }
        for ($b = 4; $b < 8; $b++) {
            $promo[] = $all[$b];
        }
        for ($c = 8; $c < 12; $c++) {
            $current[] = $all[$c];
        }

        $response['bestSeller'] = $bestSeller;
        $response['promo']      = $promo;
        $response['current']    = $current;

        return response()->json([
            'data'	    => $response,
            'message'   => 'Data found',
            'success'   => true
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
