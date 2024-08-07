<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Retrieve search and sort parameters from the request
        $search = $request->input('search');
        $sort = $request->input('sort');

        // Query the products with search and sorting
        $query = Product::query();

        // Apply search if present
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Apply sorting if present
        if ($sort != '') {
            switch ($sort) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                default:
                    // Default sorting can be applied here, e.g., by created_at
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            // Default sorting if no sort is applied
            $query->orderBy('created_at', 'desc');
        }

        // Paginate the results
        $products = $query->paginate(10);

        if (request()->expectsJson()) {
            return response()->json($products);
        }

        if (auth()->user()->is_admin) {
            return view('admin.products.index', [
                'products' => $products,
                'search' => $search,
                'sort' => $sort,
            ]);
        }

        return view('user.products.index', ['products' => $products]);
    }
    
    // public function export()
    // {
    //     return Excel::download(new ProductsExport, 'products_' . now()->format('Ymd') . '.xlsx');
    // }

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

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
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
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
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

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
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

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
