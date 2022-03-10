<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $data['products'] = Product::all();
        $data['categories'] = Category::all();
        return view('products.index', $data);
    }

    public function create()
    {
        $data['categories'] = Category::all();
        return view('products.create', $data);
    }

    public function store(Request $request)
    {
        //validate the input
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'is_active' => 'required|boolean',
        ]);

        //creat a new product
        Product::create($request->all());

        //redirect the user and send friendly message
        return redirect()->route('products.index')->with('success','Product created successfully');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $data['product'] = $product;
        $data['categories'] = Category::all();
        return view('products.edit', $data);
    }

    public function update(Request $request, Product $product)
    {
        //validate the input
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',            
            'is_active' => 'required|boolean',
        ]);

        //update product
        $product->update($request->all());

        //redirect the user and send friendly message
        return redirect()->route('products.index')->with('success','Product updated successfully');
    }

    public function destroy(Product $product)
    {
        //delete the product
        $product->delete();

        //redirect the user with a success message
        return redirect()->route('products.index')->with('success','Product deleted successfully');
    }

    public function status(Product $product)
    {
        
        if ($product->is_active == 1) 
         {
            $product->is_active = 0;
            $product->save();         
         }
        else 
         {
            $product->is_active = 1;
            $product->save();    
         }

         return redirect()->back()->with('success','Product Status changed successfully');
        
    }
}
