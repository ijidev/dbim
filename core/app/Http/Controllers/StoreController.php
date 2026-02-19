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
        $cart = session()->get('cart', []);
        if(empty($cart)) {
            return redirect()->route('store.index')->with('error', 'Your cart is empty.');
        }

        // Logic to grant book access for purchased books
        $purchasedBook = null;
        if (auth()->check()) {
            foreach ($cart as $id => $details) {
                $product = Product::with('book')->find($id);
                if ($product && $product->book) {
                    \App\Models\UserBookCollection::updateOrCreate(
                        ['user_id' => auth()->id(), 'book_id' => $product->book->id],
                        ['purchased' => true]
                    );
                    $purchasedBook = $product->book;
                }
            }
        }

        // Simulated checkout processing
        session()->forget('cart');
        
        if ($purchasedBook) {
            return redirect()->route('store.success', $purchasedBook->id);
        }

        return redirect()->route('store.index')->with('success', 'Order placed successfully!');
    }

    public function success(Book $book = null)
    {
        return view('frontend.store.success', compact('book'));
    }
}
