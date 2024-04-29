<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopRequest;
use App\Http\Resources\ShopResource;
use App\Models\Shop;
use App\Services\ShopService;

class ShopController extends Controller
{
    protected $shop;

    function __construct(ShopService $shop)
    {
        $this->shop = $shop;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shops = ShopResource::collection(Shop::get());
        return $this->success($shops, "success", 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShopRequest $request)
    {
        // return $request->all();
        $data = $request->validated();
        $data['shop_code'] = Shop::generateShopCode();
        // return $data;
        $shop = $this->shop->insert($data);

        if ($shop) {
            return $this->success(ShopResource::make($shop), "success", 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $shop = new ShopResource($this->shop->getDataById($id));
        // dd($shop);
        if ($shop) {
            return $this->success(ShopResource::make($shop), "success", 200);

        } else {
            return $this->error($shop, 'No data found', 404);

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ShopRequest $request, string $id)
    {

        $shop = $this->shop->update($request->all(), $id);
        // return $shop;

        if ($shop) {
            return $this->success(ShopResource::make($shop), "success", 200);

        } else {
            return $this->error($shop, 'No data found', 404);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $shop = $this->shop->destroy($id);
        if($shop) {
            return $this->success(null, 'deleted', 200);
       }else {
        return $this->error(null, "No data found",404 );    

       }
    }
}