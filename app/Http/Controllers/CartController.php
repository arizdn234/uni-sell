<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

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
    
    public function updateCart(Request $request, $itemId)
    {
        $quantity = $request->input('quantity');
        
        $cart = Session::get('cart', []);
        \Log::info('Cart contents:', $cart);
        
        if (isset($cart[$itemId])) {
            $cart[$itemId]['quantity'] = $quantity;
            Session::put('cart', $cart);

            $itemTotal = $cart[$itemId]['price'] * $quantity;
            $cartTotal = array_reduce($cart, function ($carry, $item) {
                return $carry + ($item['price'] * $item['quantity']);
            }, 0);

            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully!',
                'item_total' => $itemTotal,
                'cart_total' => $cartTotal
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Item not found.']);
    }

    // Remove an item from the cart
    public function removeCart($itemId)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$itemId])) {
            unset($cart[$itemId]);
            Session::put('cart', $cart);

            $cartTotal = array_reduce($cart, function ($carry, $item) {
                return $carry + ($item['price'] * $item['quantity']);
            }, 0);

            return response()->json([
                'success' => true,
                'message' => 'Item removed successfully!',
                'cart_total' => $cartTotal
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Item not found.']);
    }

}
