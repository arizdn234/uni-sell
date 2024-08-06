<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $products = Product::with('category', 'reviews')->get();
        // Get paginated products with 10 items per page
        $products = Product::with('category', 'reviews')->paginate(10);

        if (request()->expectsJson()) {
            return response()->json($products);
        }

        if (auth()->user()->is_admin) {
            return view('admin.products.index', ['products' => $products]);
        }

        return view('user.products.index', ['products' => $products]);
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image_url' => 'nullable|string',
        ]);

        $product = Product::create($validatedData);

        if ($request->expectsJson()) {
            return response()->json($product, 201);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $product->load('category', 'reviews');

        if (request()->expectsJson()) {
            return response()->json($product);
        }

        return view('admin.products.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', ['product' => $product]);
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
            'price' => 'numeric|min:0',
            'stock' => 'integer|min:0',
            'category_id' => 'exists:categories,id',
            'image_url' => 'nullable|string',
        ]);

        $product->update($validatedData);

        if ($request->expectsJson()) {
            return response()->json($product);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Product deleted successfully']);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
