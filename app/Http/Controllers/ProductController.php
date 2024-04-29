<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Traits\HttpResponses;

class ProductController extends Controller
{
    use HttpResponses;
    protected $product;

    public function __construct(ProductService $product){
        $this->product = $product;
    }

    public function index()
    {
        $productList = ProductResource::collection(Product::with('ProductCategory')->get());
        // return $productList;
        return $this->success($productList, 'success', 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $productCode = 'P'.mt_rand(3000, 999999);
        $validatedData['product_code'] = $productCode;
        $validatedData['product_name'] = $request->product_name;
        $validatedData['ProductCategoryId'] = $request->ProductCategoryId;
        $validatedData['price'] = $request->price;

        
        $product = $this->product->insert($validatedData);

        $resProduct = ProductResource::make($product);

        if($product){
            return $this->success($resProduct, 'success', 200);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = $this->product->getProductById($id);

        $resProduct = ProductResource::make($product);

        if($product){
       
                return $this->success($resProduct, 'success', 200);
        }else{
            return $this->error($resProduct, 'No data found', 404);

        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request,string $id)
    {
        $product = $this->product->update($request->validated(),$id);
        $resProduct = ProductResource::make($product);
        if($product){
            return $this->success($resProduct, 'success', 200);

        }else{
            return $this->error($resProduct, 'No data found', 404);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $product = $this->product->destroy($id);

        if($product) {
            return $this->success(null, 'deleted', 200);
       }else {
        return $this->error(null, "No data found",404 );    

       }
    }
}
