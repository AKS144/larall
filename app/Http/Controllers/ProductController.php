<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Product as ProductResource;

class ProductController extends Controller
{
    public function index()
    {
        //return ProductResource::collection(Product::all());
        return ProductResource::collection(Product::orderBy('created_at', 'desc')->paginate(6));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $product = Product::create($request->all());
        //return new ProductResource($product);

        if(is_null($product)){
            return response()->json(["message"=>"added!"], 404);
        }  
        else{
            $product->update($request->all());
            return response()->json($product, 201); 
        }
    }

    public function show($id)
    {
        $product = Product::find($id);
        return new ProductResource($product);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->all());
        return new ProductResource($product);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return new ProductResource($product);
    }
}
