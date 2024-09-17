<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\System\ProductPrice;
use Illuminate\Http\Request;

class ProductPriceController extends Controller
{
    private function validateRequest(Request $request): void
    {
        $request->validate([
            'product_id' => 'required',
            'price'      => 'required|string|max:255',
        ]);
    }

    public function create(Request $request)
    {
        $this->validateRequest($request);

        $data    = (object) $request->all();
        $service = ProductPrice::createItem($data);

        return response()->json($service, 201);
    }

    public function update(Request $request)
    {
        $this->validateRequest($request);

        $data    = (object) $request->all();
        $service = ProductPrice::updateItem($data);

        return response()->json($service, 201);
    }

    public function disable(Request $request)
    {
        $id      = $request->id;
        $service = ProductPrice::disableItem($id);

        return response()->json($service, 201);
    }

    public function getItems(Request $request)
    {
        $service = ProductPrice::getItems();

        return response()->json($service, 201);
    }

    public function getItem(Request $request)
    {
        $id      = $request->id;
        $service = ProductPrice::getItem($id);

        return response()->json($service, 201);
    }
}
