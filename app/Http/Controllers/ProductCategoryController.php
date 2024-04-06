<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Resources\ProductCategoryRource;
use App\Models\ProductCategory;
use App\Services\ProductCategoryService;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    protected $productCategory;

    
    public function __construct(ProductCategoryService $productCategory)
    {
        $this->productCategory = $productCategory;
    }


    public function index()
    {
        $productCategories = ProductCategory::get();
        return ProductCategoryRource::collection($productCategories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductCategoryRequest $request)
    {

        $productCategory =  $this->productCategory->insert($request->all());

        if($productCategory) {
            return response()->json([
                'data' => $productCategory,
                'status' => true
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $productCategory =  $this->productCategory->getDataById($id);

       if($productCategory) {
            return response()->json([
                'data' => $productCategory,
                'status' => true
            ], 200);
       }else {
            return response()->json([
                'message' => 'No data found',
                'status' => false
            ], 404);
       }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $productCategory =  $this->productCategory->update($request->all(), $id);

        if($productCategory) {
            return response()->json([
                'message' => 'Successfully updated data',
                'status' => true
            ], 200);
       }else {
            return response()->json([
                'message' => 'No data found',
                'status' => false
            ], 404);
       }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      $productCategory =   $this->productCategory->destroy($id);

        if($productCategory) {
            return response()->json([
                'message' => 'Successfully deleted data',
                'status' => true
            ], 200);
       }else {
            return response()->json([
                'message' => 'No data found',
                'status' => false
            ], 404);
       }
    }
}
