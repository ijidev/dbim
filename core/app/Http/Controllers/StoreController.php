<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $products = Product::where('status', true)->paginate(12);
        return view('frontend.store.index', compact('products'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $relatedProducts = Product::where('status', true)->where('id', '!=', $product->id)->take(4)->get();
        return view('frontend.store.show', compact('product', 'relatedProducts'));
    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('frontend.store.cart', compact('cart'));
    }

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "title" => $product->title,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        if(empty($cart)) {
            return redirect()->route('store.index')->with('error', 'Your cart is empty.');
        }
        return view('frontend.store.checkout', compact('cart'));
    }

    public function processCheckout(Request $request)
    {
        // Simulated checkout processing
        session()->forget('cart');
        return redirect()->route('store.index')->with('success', 'Order placed successfully! (Simulated)');
    }
}
