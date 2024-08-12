<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort');

        $query = Cart::query()
        ->with('user')
        ->whereHas('user', function ($query) {
            $query->where('is_admin', false);
        });

        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        if ($sort != '') {
            switch ($sort) {
                case 'user_name_asc':
                    $query->join('users', 'carts.user_id', '=', 'users.id')
                        ->orderBy('users.name', 'asc');
                    break;
                case 'user_name_desc':
                    $query->join('users', 'carts.user_id', '=', 'users.id')
                        ->orderBy('users.name', 'desc');
                    break;
                case 'total_asc':
                    $query->orderBy('total', 'asc');
                    break;
                case 'total_desc':
                    $query->orderBy('total', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $carts = $query->paginate(10);

        if ($request->expectsJson()) {
            return response()->json($carts);
        }

        if (auth()->user()->is_admin) {
            return view('admin.carts.index', [
                'carts' => $carts,
                'search' => $search,
                'sort' => $sort,
            ]);
        }

        return view('user.cart.index', ['carts' => $carts]);
    }

    public function show($id)
    {
        $cart = Cart::with('items.product')->findOrFail($id);

        return view('admin.carts.show', compact('cart'));
    }

    /**
     * Show the form for creating a new cart.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('admin.carts.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $cart = Cart::create($validatedData);

        return response()->json($cart, 201);
    }

    public function edit($id)
    {
        $cart = Cart::with('items.product')->findOrFail($id);
        return view('admin.carts.edit', compact('cart'));
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::with('items')->findOrFail($id);

        $cart->save();

        foreach ($request->input('items', []) as $itemId => $itemData) {
            $item = CartItem::findOrFail($itemId);
            $item->quantity = $itemData['quantity'];
            $item->save();
        }

        return redirect()->route('carts.index')->with('success', 'Cart updated successfully.');
    }

    public function destroy(Cart $cart)
    {
        if (!$cart) {
            \Log::error('Cart not found or already deleted:', ['cart_id' => $cart->id ?? null]);
        }


        $cart->items()->delete();
        $cart->delete();


        if (request()->expectsJson()) {
            return response()->json(['message' => 'Cart deleted successfully']);
        }

        return redirect()->route('carts.index')->with('success', 'Cart deleted successfully.');
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        $userId = auth()->id(); 

        try {
            
            $cart = Cart::firstOrCreate(['user_id' => $userId]);

            
            $cartItem = CartItem::where('cart_id', $cart->id)
                                ->where('product_id', $productId)
                                ->first();

            if ($cartItem) {
                
                $cartItem->increment('quantity', $quantity);
            } else {
                
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Product added to cart']);
        } catch (\Exception $e) {
            
            \Log::error('Failed to add product to cart', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to add product to cart']);
        }
    }
}
