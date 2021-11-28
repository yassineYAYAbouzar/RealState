<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add($productId)
    {

        $produt = Product::find($productId);
        \Cart::session(auth()->id())->add(array(
            'id' => $produt->id,
            'name' => $produt->name,
            'price' => $produt->price,
            'quantity' => 4,
            'attributes' => array(),
            'associatedModel' => $produt
        ));
        return redirect()->route('cart.index');
    }
    public function index()
    {
        $cartitems=\Cart::session(auth()->id())->getContent();
        return view('cart.index',compact('cartitems'));
    }
    public function destroy($itemId)
    {
        \Cart::session(auth()->id())->remove($itemId);
        return back();
    }
    public function update($rowId)
    {
        \Cart::session(auth()->id())->update($rowId,[
            'quantity' =>array(
                'relative'=>false,
                'value'=> request('quantity'),
            )
        ]);
        return back();
    }
}
