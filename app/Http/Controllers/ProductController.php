<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new ProductResource(Product::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->safe()->except(['image']);

            $imageUrl = $this->storeFile($request);
            if (!empty($imageUrl))
                $data['image_url'] = $imageUrl;

            $product = Product::create($data);
            DB::commit();

            return new ProductResource($product);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if ($product)
            $response = new ProductResource($product);
        else
            $response = response()->json(['data' => 'Product not found.'], 404);

        return $response;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProductRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $product = Product::find($id);
            if ($product) {
                $data = $request->safe()->except(['image']);

                $imageUrl = $this->storeFile($request, $product->id);
                if (!empty($imageUrl))
                    $data['image_url'] = $imageUrl;

                $product->update($data);
                DB::commit();

                return new ProductResource($product);
            }
            return response()->json(['data' => 'Product not found.'], 404);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            $response = 'Product deleted successfully.';
        } else
            $response = 'Product not found.';

        return response()->json(['data' => $response]);
    }

    public function storeFile($request, $productId = null)
    {
        $imageUrl = null;
        if ($request->hasFile('image')) {
            $productFile = $request->file('image');
            $imageUrl = Product::storeFile($productFile, $productId);
        }
        return $imageUrl;
    }

    public function searchProduct($searchQuery)
    {
        $products = Product::where('name', 'LIKE', '%' . $searchQuery . '%')
            ->orWhere('description', 'LIKE', '%' . $searchQuery . '%')->get();
        if (count($products))
            $response = $products;
        else
            $response = 'No product found';
        return response()->json(['data' => $response]);
    }
}
