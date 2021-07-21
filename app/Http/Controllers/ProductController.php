<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all()->toArray();
        return array_reverse($products);      
    }

    public function store(Request $request)
    {
        // var_dump($request->file);
        if (!is_string($request->file)) {
            $file_name = time().'_'.$request->file->getClientOriginalName();
            $file_path = $request->file('file')->storeAs('uploads', $file_name, 'public');
            $product = new Product([
                'name' => $request->input('name'),
                'detail' => $request->input('detail'),
                'path' => '/storage/' . $file_path
            ]);
        } else {
            $product = new Product([
                'name' => $request->input('name'),
                'detail' => $request->input('detail')
            ]);
        }
        $product->save();

        // return response()->json($request->file);
        return response()->json('Product created!');
    }

    public function show($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    public function update($id, Request $request)
    {
        $product = Product::find($id);
        $product->update($request->all());

        return response()->json('Product updated!');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return response()->json('Product deleted!');
    }
}